<?php
include('../config.php');

$id = $_GET['id'];
$table = $_GET['table'];

if (!is_numeric($id)) {
    die("Invalid ID");
}

$course_name = isset($_GET['course_name']) ? $_GET['course_name'] : '';
$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
$subject_name = isset($_GET['subject_name']) ? $_GET['subject_name'] : '';
$theory_hours = isset($_GET['theory_hours']) ? $_GET['theory_hours'] : '';
$practical_hours = isset($_GET['practical_hours']) ? $_GET['practical_hours'] : '';
$semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$academic_year = isset($_GET['academic_year']) ? $_GET['academic_year'] : '';
$day_of_week = isset($_GET['day_of_week']) ? $_GET['day_of_week'] : '';
$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
$section = isset($_GET['section']) ? $_GET['section'] : '';
$teacher_id = isset($_GET['teacher1']) ? $_GET['teacher1'] : '';

$table_name = "week_" . $table . "_" . $course_name . "_" . $subject_name . "_" . chr($id + 65);  // แปลง ID เป็นตัวอักษร

$sql_select = "SELECT * FROM $table_name";

// Create table if it doesn't exist
$sql_create_table = "CREATE TABLE IF NOT EXISTS $table_name (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image LONGBLOB NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    student_number VARCHAR(20) NOT NULL,
    Faculty VARCHAR(255) NOT NULL,
    Field_of_study VARCHAR(255) NOT NULL
)";

try {
    // Create table
    $conn->exec($sql_create_table);
    echo "Table $table_name created successfully. ";

    // Query to select data
    $result = $conn->query($sql_select);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Course Details</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        caption {
            caption-side: top;
            font-weight: bold;
            margin: 10px 0;
        }
        .full-width {
            width: 80vw;
            overflow-x: auto;
        }
        
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Project การเช็คชื่อโดยการตรวจจับใบหน้า</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/myproject/index.php">กรอกข้อมูลนักศึกษา</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5%E0%B8%9C%E0%B8%B9%E0%B9%89%E0%B8%AA%E0%B8%AD%E0%B8%99/index.php">กรอกข้อมูลผู้สอน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/%E0%B8%95%E0%B8%B2%E0%B8%A3%E0%B8%B2%E0%B8%87%E0%B8%AA%E0%B8%AD%E0%B8%99/index.php">ตารางสอน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/%E0%B8%AB%E0%B8%A5%E0%B8%B1%E0%B8%81%E0%B8%AA%E0%B8%B9%E0%B8%95%E0%B8%A3/index.html">หลักสูตร</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/course-app/add.php">ข้อมูลวิชาเรียน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/room/index.html">ข้อมูลห้องเรียน</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="display.php">เเสดงข้อมูลนักศึกษา</a></li>
                            <li class="nav-item"><a class="nav-link" href="course_app/add.php">จัดการวิชาเรียน</a></li>
                            <li class="nav-item"><a class="nav-link" href="room/index.html">จัดการห้องเรียน</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container-fluid mt-4">
                <h1><?php echo htmlspecialchars($subject_name); ?></h1>
                <hr>
                <!-- Search form -->
                <form action="weeksubject.php" method="GET" class="mb-3">
                    <!-- Hidden inputs -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($subject_id); ?>">
                    <input type="hidden" name="subject_name" value="<?php echo htmlspecialchars($subject_name); ?>">
                    <input type="hidden" name="course_name" value="<?php echo htmlspecialchars($course_name); ?>">
                    <input type="hidden" name="theory_hours" value="<?php echo htmlspecialchars($theory_hours); ?>">
                    <input type="hidden" name="practical_hours" value="<?php echo htmlspecialchars($practical_hours); ?>">
                    <input type="hidden" name="semester" value="<?php echo htmlspecialchars($semester); ?>">
                    <input type="hidden" name="academic_year" value="<?php echo htmlspecialchars($academic_year); ?>">
                    <input type="hidden" name="day_of_week" value="<?php echo htmlspecialchars($day_of_week); ?>">
                    <input type="hidden" name="start_time" value="<?php echo htmlspecialchars($start_time); ?>">
                    <input type="hidden" name="end_time" value="<?php echo htmlspecialchars($end_time); ?>">
                    <input type="hidden" name="section" value="<?php echo htmlspecialchars($section); ?>">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="ค้นหาข้อมูลนักศึกษา" name="search">
                        <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                    </div>
                </form>

                <div class="mt-5">
                    <h1 class="mb-4">Course Details : <?php echo htmlspecialchars($subject_name); ?></h1>
                    <p>รายละเอียดของคอร์สที่มี ID: <?php echo htmlspecialchars($id); ?></p>
                    <p>Subject Name: <?php echo htmlspecialchars($subject_name); ?></p>
                    <p>Course Name: <?php echo htmlspecialchars($course_name); ?></p>
                    <p>Theory Hours: <?php echo htmlspecialchars($theory_hours); ?></p>
                    <p>Practical Hours: <?php echo htmlspecialchars($practical_hours); ?></p>
                    <p>Semester: <?php echo htmlspecialchars($semester); ?></p>
                    <p>Academic Year: <?php echo htmlspecialchars($academic_year); ?></p>
                    <p>Day of Week: <?php echo htmlspecialchars($day_of_week); ?></p>
                    <p>Start Time: <?php echo htmlspecialchars($start_time); ?></p>
                    <p>End Time: <?php echo htmlspecialchars($end_time); ?></p>
                    <p>Section: <?php echo htmlspecialchars($section); ?></p>
                    <p>teacher: <?php echo htmlspecialchars($teacher_id); ?></p>

                    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projecta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
            // Fetch data from weeks table
            $sql = "SELECT week_number, week_date, on_time_time, late_time, absent_time FROM weeks";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='full-width'>";
                echo "<table class='table table-striped'>";
                echo "<caption>ตารางสัปดาห์</caption>";
                echo "<thead><tr><th>ลำดับสัปดาห์</th><th>วัน/เดือน/ปี</th><th>เวลาเช็คชื่อที่ไม่สาย</th><th>เวลาเช็คชื่อที่สาย</th><th>เวลาเช็คขาดเรียน</th><th>Action</th></tr></thead>";
                echo "<tbody>";

                while ($row = $result->fetch_assoc()) {
                    $week_number = $row["week_number"];
                    $week_date = $row["week_date"];
                    $on_time_time = $row["on_time_time"];
                    $late_time = $row["late_time"];
                    $absent_time = $row["absent_time"];
                    $target_page = "week_details.php?week_number=" . urlencode($week_number) . "&id=" . urlencode($id);

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($week_number) . "</td>";
                    echo "<td>" . htmlspecialchars($week_date) . "</td>";
                    echo "<td>" . htmlspecialchars($on_time_time) . "</td>";
                    echo "<td>" . htmlspecialchars($late_time) . "</td>";
                    echo "<td>" . htmlspecialchars($absent_time) . "</td>";
                    echo "<td><a href='$target_page' class='btn btn-primary'>Go</a></td>";
                    echo "</tr>";
                }

                echo "</tbody></table></div>";
            } else {
                echo "<p>ไม่มีข้อมูล</p>";
            }

            $conn->close();
            ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9nK59GQKTxW9fElC5n7xS2vjtBlz5W0Q4yt7BzpXk06g4UB9v8V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-cv5xK+8I2kFfbRgI+Q7Xckn2Sm6hf6cH9PjTZhxDSz69iXzRzTjS8/aHpjkPI5Wf1" crossorigin="anonymous"></script>
</body>
</html>

