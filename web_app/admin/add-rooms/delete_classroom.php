<?php
// การเชื่อมต่อกับฐานข้อมูล MySQL
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

// ตรวจสอบว่ามีการส่งค่า id มาหรือไม่
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // เตรียมคำสั่ง SQL เพื่อลบข้อมูลจากฐานข้อมูล
    $sql = "DELETE FROM classrooms WHERE id = $id";

    // ส่งคำสั่ง SQL ไปทำงาน
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Room ID not provided.";
}

if ($conn->query($sql) === TRUE) {
    // หากลบข้อมูลสำเร็จให้ Redirect กลับไปยังหน้า display_classrooms.php
    header("Location: display_classrooms.php");
    exit(); // ออกจากสคริปต์เพื่อป้องกันการทำงานต่อ
} else {
    echo "Error deleting record: " . $conn->error;
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
