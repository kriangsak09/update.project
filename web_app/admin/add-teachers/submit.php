<?php
$servername = "localhost";
$username = "root"; // ใส่ชื่อผู้ใช้ MySQL ของคุณ
$password = ""; // ใส่รหัสผ่าน MySQL ของคุณ
$dbname = "projecta";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$teacher_id = $_POST['teacher_id'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$first_name_eng = $_POST['first_name_eng'];
$last_name_eng = $_POST['last_name_eng'];
$email = $_POST['email'];

// เตรียมคำสั่ง SQL
$sql = "INSERT INTO teachers (teacher_id, faculty, department, first_name, last_name, first_name_eng, last_name_eng, email)
        VALUES ('$teacher_id', '$faculty', '$department', '$first_name', '$last_name', '$first_name_eng', '$last_name_eng', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
        alert('บันทึกข้อมูลสำเร็จ');
        window.location.href='index.php';
    </script>";
} else {
    echo "ข้อผิดพลาด: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
