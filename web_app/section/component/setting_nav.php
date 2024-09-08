<?php
include 'config.php';

// รับข้อมูลผู้ใช้จาก URL หรือ Session
$userEmail = isset($_GET['user']) ? htmlspecialchars($_GET['user']) : (isset($_SESSION['userEmail']) ? $_SESSION['userEmail'] : '');
$userName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : (isset($_SESSION['userName']) ? $_SESSION['userName'] : '');
$userImage = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : (isset($_SESSION['userImage']) ? $_SESSION['userImage'] : '');

// บันทึกข้อมูลลงใน Session หากมีข้อมูลใหม่
if (!empty($userEmail)) {
    $_SESSION['userEmail'] = $userEmail;
    $_SESSION['userName'] = $userName;
    $_SESSION['userImage'] = $userImage;
}

// ตรวจสอบว่าผู้ใช้มีการล็อกอินหรือไม่
$isLoggedIn = !empty($userEmail);

// สร้าง URL สำหรับการออกจากระบบ
$logoutUrl = $isLoggedIn ? 'http://localhost:5173/?logout=true' : '#';

// การออกจากระบบ
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: http://localhost:5173/"); // Redirect to login page
    exit();
}

// รับข้อมูลชื่อผู้ใช้จากเซสชัน
$userName = isset($_SESSION['userName']) ? htmlspecialchars($_SESSION['userName']) : '';

// ตรวจสอบว่าผู้ใช้มีการล็อกอินหรือไม่
if (empty($userName)) {
    die("Please log in first.");
}

// รับค่า academic_year และ semester จากฟอร์ม
$selectedAcademicSemester = isset($_GET['academic_semester']) ? htmlspecialchars($_GET['academic_semester']) : '';

// แยกค่า academic_year และ semester
$selectedAcademicYear = '';
$selectedSemester = '';
if (!empty($selectedAcademicSemester)) {
    list($selectedAcademicYear, $selectedSemester) = explode('-', $selectedAcademicSemester);
}

// เตรียม SQL Query สำหรับค้นหาข้อมูล
$sql = "
    SELECT c.*,
           cl.room_number, cl.floor, cl.building
    FROM courses c
    LEFT JOIN classrooms cl ON c.classroom_id = cl.id
    WHERE (c.teacher_id = :userName
           OR c.teacher2_id = :userName
           OR c.teacher3_id = :userName)
";

// เพิ่มเงื่อนไขการกรองตาม academic_year และ semester
if (!empty($selectedAcademicYear) || !empty($selectedSemester)) {
    $sql .= " AND (";
    if (!empty($selectedAcademicYear)) {
        $sql .= " c.academic_year = :academicYear";
        if (!empty($selectedSemester)) {
            $sql .= " AND";
        }
    }
    if (!empty($selectedSemester)) {
        $sql .= " c.semester = :semester";
    }
    $sql .= ")";
}

try {
    // ค้นหาข้อมูลในตาราง courses ตาม teacher_id ที่ตรงกับชื่อผู้ใช้
    $stmt = $conn->prepare($sql);

    // Binding parameters
    $stmt->bindParam(':userName', $userName);
    if (!empty($selectedAcademicYear)) {
        $stmt->bindParam(':academicYear', $selectedAcademicYear);
    }
    if (!empty($selectedSemester)) {
        $stmt->bindParam(':semester', $selectedSemester);
    }

    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    // Query สำหรับดึงข้อมูล academic_year และ semester โดยกรองตาม teacher_id ของผู้ใช้
    $stmt = $conn->prepare("
        SELECT DISTINCT academic_year, semester
        FROM courses
        WHERE teacher_id = :userName
        OR teacher2_id = :userName
        OR teacher3_id = :userName
    ");
    $stmt->bindParam(':userName', $userName);
    $stmt->execute();
    $academicSemesters = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// สีของปุ่ม Section มีดังนี้ โดยสีพวกนี้จะทำการสุ่มตามที่เราเพิ่มในโค้ดนี้
$colors = ['#4a235a', '#943126', '#196f3d', '#21618c', '#283747', '#af601a'];

// Function to get color for a course ID
function getColorForCourse($courseId)
{
    global $colors;
    if (!isset($_SESSION['course_colors'])) {
        $_SESSION['course_colors'] = [];
    }
    if (!isset($_SESSION['course_colors'][$courseId])) {
        // Generate a random color index
        $_SESSION['course_colors'][$courseId] = rand(2, count($colors) - 1);
    }
    return $colors[$_SESSION['course_colors'][$courseId]];
}

// สุ่มสีสำหรับแต่ละวิชา
foreach ($courses as $index => $course) {
    $colorIndex = $index % count($colors);
    $course['button_color'] = $colors[$colorIndex];
    $courses[$index] = $course; // อัพเดตข้อมูล
}

// Assuming you have $courses array populated
function dayOfWeekToNumber($day)
{
    $days = ['Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6];
    return $days[$day];
}

usort($courses, function ($a, $b) {
    $dayA = dayOfWeekToNumber($a['day_of_week']);
    $dayB = dayOfWeekToNumber($b['day_of_week']);

    if ($dayA == $dayB) {
        return strtotime($a['start_time']) - strtotime($b['start_time']);
    }
    return $dayA - $dayB;
});

?>
