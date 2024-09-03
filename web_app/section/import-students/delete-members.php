<?php
session_start(); // เริ่มต้น session
include('config.php');

if (isset($_GET['id']) && isset($_GET['table_name'])) {

    $id = $_GET['id'];
    $table_name = $_GET['table_name'];
    $subject_id = $_SESSION['subject_id'];

    // เชื่อมต่อฐานข้อมูล
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ลบข้อมูลนักศึกษา
    $sql = "DELETE FROM $table_name WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // เรียก Python API เพื่ออัปเดตไฟล์ .json
        $data = array('table_name' => $table_name);
        $url = 'http://localhost:5000/recognize'; // URL ของ Python API
        
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        if ($result === FALSE) {
            // จัดการกรณีที่เกิดข้อผิดพลาดในการเรียก API
            echo "Error calling API to update JSON file.";
        }

        // ส่งค่ากลับไปยัง manage-members Page หลังจากเรียกใช้ API เสร็จ
        header("Location: manage-members.php?table_name=" . urlencode($table_name) . "&subject_id=" . urlencode($subject_id) . "&message=Record deleted successfully");
        exit;    } else {
        echo "Error deleteing record: " . $conn->error;
    }

    if ($stmt->affected_rows > 0) {
        echo "Student deleted successfully.";
    } else {
        echo "Error deleting student: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request.";
}
?>
