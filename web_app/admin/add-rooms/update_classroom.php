<?php
// เชื่อมต่อฐานข้อมูล MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projecta";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลที่ต้องการอัปเดตจากฟอร์ม
$id = $_POST['id'];
$room_number = $_POST['room_number'];
$floor = $_POST['floor'];
$building = $_POST['building'];

// เตรียมคำสั่ง SQL เพื่ออัปเดตข้อมูล
$sql = "UPDATE classrooms SET room_number='$room_number', floor='$floor', building='$building' WHERE id=$id";

// ทำการอัปเดตข้อมูล
if ($conn->query($sql) === TRUE) {
    // อัปเดตสำเร็จ ให้ Redirect กลับไปยังหน้า display_classrooms.php
    header("Location: display_classrooms.php");
    exit(); // ออกจากสคริปต์เพื่อป้องกันการทำงานต่อ
} else {
    echo "Error updating record: " . $conn->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
