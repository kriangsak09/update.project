<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projecta";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าจากฟอร์ม
$course_name = $_POST['course_name'];
$description = $_POST['description'];
$duration = $_POST['duration'];
$instructor = $_POST['instructor'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];

// เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล
$sql = "INSERT INTO courses_ca (course_name, description, duration, instructor, start_date, end_date, faculty, department)
VALUES ('$course_name', '$description', '$duration', '$instructor', '$start_date', '$end_date', '$faculty', '$department')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
