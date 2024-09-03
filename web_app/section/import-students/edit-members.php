<?php
session_start(); // เริ่มต้น session
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projecta";

$table_name = isset($_GET['table_name']) ? strtolower($_GET['table_name']) : '';
$id = $_GET['id'];
$subject_id = $_SESSION['subject_id'];

// สร้างการเชื่อมต่อกับ MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลปัจจุบันเพื่อแสดงในฟอร์ม
$sql = "SELECT * FROM $table_name WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_number = $_POST['student_number'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $Faculty = $_POST['Faculty'];
    $Field_of_study = $_POST['Field_of_study'];

    $update_sql = "UPDATE $table_name SET student_number=?, first_name=?, last_name=?, Faculty=?, Field_of_study=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $student_number, $first_name, $last_name, $Faculty, $Field_of_study, $id);

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
        } else {
            //ส่งค่ากลับไปยัง manage-members Page
            header("Location: manage-members.php?table_name=" . urlencode($table_name) . "&subject_id=" . urlencode($subject_id) . "&message=Record updated successfully");
            exit;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../styles.css" rel="stylesheet">
    <link href="./edit-member_responsive.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Student</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="student_number" class="form-label">Student Number</label>
                <input type="text" class="form-control" id="student_number" name="student_number" value="<?= htmlspecialchars($row['student_number']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="Faculty" class="form-label">Faculty</label>
                <input type="text" class="form-control" id="Faculty" name="Faculty" value="<?= htmlspecialchars($row['Faculty']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="Field_of_study" class="form-label">Field of Study</label>
                <input type="text" class="form-control" id="Field_of_study" name="Field_of_study" value="<?= htmlspecialchars($row['Field_of_study']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
            <a href="javascript:window.history.back()" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </div>
</body>
</html>
