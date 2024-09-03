<?php
// การตั้งค่าฐานข้อมูล
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

// ดึงข้อมูลจาก POST และทำการตรวจสอบข้อมูล
$table_name_redirect_url = isset($_POST['table_name']) ? $_POST['table_name'] : '';
$table_weeks_name = isset($_POST['table_weeks_name']) ? $_POST['table_weeks_name'] : '';
$week_date = isset($_POST['week_date']) ? htmlspecialchars($_POST['week_date']) : '';
$week_number = isset($_POST['week_number']) ? htmlspecialchars($_POST['week_number']) : 0;
$id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : 0;
$subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '';
$upload_time = isset($_POST['upload_time']) ? htmlspecialchars($_POST['upload_time']) : '';
$total_faces_on_time = isset($_POST['total_facesOnTime']) ? intval($_POST['total_facesOnTime']) : 0;
$names_on_time = isset($_POST['faces_on_time']) ? htmlspecialchars($_POST['faces_on_time']) : '';
$total_faces_late_time = isset($_POST['total_facesLateTime']) ? intval($_POST['total_facesLateTime']) : 0;
$names_late_time = isset($_POST['faces_late_time']) ? htmlspecialchars($_POST['faces_late_time']) : '';
$total_faces_absent_time = isset($_POST['total_facesAbsentTime']) ? intval($_POST['total_facesAbsentTime']) : 0;
$names_absent_time = isset($_POST['faces_absent_time']) ? htmlspecialchars($_POST['faces_absent_time']) : '';

// สร้างชื่อของตาราง (ทำการตรวจสอบชื่อของตาราง)
$table_name = preg_replace("/[^a-zA-Z_]/", "", "report_daily_" . $subject);

// ฟังก์ชันสำหรับสร้างตารางถ้ายังไม่มี
function createTableIfNotExists($conn, $table_name) {
    $create_table_sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        week_number INT(11) NOT NULL,
        week_date DATE NOT NULL,
        upload_time DATETIME NOT NULL,
        total_faces_on_time INT(11) NOT NULL,
        names_on_time TEXT NOT NULL,
        total_faces_late_time INT(11) NOT NULL,
        names_late_time TEXT NOT NULL,
        total_faces_absent_time INT(11) NOT NULL,
        names_absent_time TEXT NOT NULL
    )";

    if ($conn->query($create_table_sql) === TRUE) {
        return true;
    } else {
        return "ข้อผิดพลาดในการสร้างตาราง: " . $conn->error;
    }
}

// ฟังก์ชันสำหรับแทรกข้อมูลลงในตาราง
function insertData($conn, $table_name, $week_number, $week_date, $upload_time, $total_faces_on_time, $names_on_time, $total_faces_late_time, $names_late_time, $total_faces_absent_time, $names_absent_time) {
    $insert_sql = "INSERT INTO `$table_name` (week_number, week_date, upload_time, total_faces_on_time, names_on_time, total_faces_late_time, names_late_time, total_faces_absent_time, names_absent_time)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    if ($stmt) {
        $stmt->bind_param("ississsss", $week_number, $week_date, $upload_time, $total_faces_on_time, $names_on_time, $total_faces_late_time, $names_late_time, $total_faces_absent_time, $names_absent_time);

        if ($stmt->execute()) {
            return true;
        } else {
            return "ข้อผิดพลาดในการดำเนินการ: " . $stmt->error;
        }

        $stmt->close();
    } else {
        return "ข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error;
    }
}

// สร้างตารางถ้ายังไม่มี
$table_creation_result = createTableIfNotExists($conn, $table_name);

// แทรกข้อมูลลงในตาราง
$data_insertion_result = insertData($conn, $table_name, $week_number, $week_date, $upload_time, $total_faces_on_time, $names_on_time, $total_faces_late_time, $names_late_time, $total_faces_absent_time, $names_absent_time);

$conn->close();

// เตรียมข้อความสำหรับ JavaScript
$message = ($table_creation_result === true && $data_insertion_result === true) ?
    "ตาราง '$table_name' ถูกสร้างขึ้นเรียบร้อยแล้ว. ข้อมูลใหม่ถูกเพิ่มเรียบร้อยแล้ว." :
    ($table_creation_result !== true ? $table_creation_result : $data_insertion_result);

// เข้ารหัสข้อความสำหรับ JavaScript
$message = addslashes($message);

// สร้าง URL สำหรับการเปลี่ยนเส้นทาง
$redirect_url = "http://192.168.1.39/myproject/Web_app/section/attendance-check.php?table_name=$table_name_redirect_url&table_weeks_name=$table_weeks_name&id=$id";

// ตรวจสอบ URL ที่สร้างขึ้น
echo $redirect_url;

 // รีไดเร็กต์ไปยังหน้า attendance-check
header("Location: $redirect_url"); 
?>
