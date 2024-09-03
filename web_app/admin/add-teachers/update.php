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

// รับข้อมูลจากฟอร์ม
$id = $_POST['id'];
$teacher_id = $_POST['teacher_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$first_name_eng = $_POST['first_name_eng'];
$last_name_eng = $_POST['last_name_eng'];
$email = $_POST['email'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];

// เตรียมคำสั่ง SQL สำหรับการอัปเดตข้อมูล
$sql = "UPDATE teachers SET teacher_id='$teacher_id', first_name='$first_name', last_name='$last_name', 
        first_name_eng='$first_name_eng', last_name_eng='$last_name_eng', email='$email', 
        faculty='$faculty', department='$department' WHERE id='$id'";

// ทำการอัปเดตข้อมูลในฐานข้อมูล
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('อัปเดตข้อมูลสำเร็จ'); window.location.href='display.php';</script>";
} else {
    echo "ข้อผิดพลาด: " . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
