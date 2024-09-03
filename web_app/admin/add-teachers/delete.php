<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projecta";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับค่า teacher_id จาก URL
$id = $_GET['id'];

// สร้างคำสั่ง SQL เพื่อลบข้อมูล
$sql = "DELETE FROM teachers WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "ลบข้อมูลสำเร็จ";
} else {
    echo "ข้อผิดพลาด: " . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();

// กลับไปยังหน้าหลัก
header("Location: display.php");
exit();
?>
