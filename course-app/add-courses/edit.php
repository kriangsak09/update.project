<?php
include('db.php');

// ดึงข้อมูลห้องเรียนและครู
$classrooms_sql = "SELECT * FROM classrooms";
$classrooms_result = $conn->query($classrooms_sql);

$teachers_sql = "SELECT id, first_name_eng, last_name_eng, teacher_id FROM teachers";
$teachers_result = $conn->query($teachers_sql);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM courses WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No course found";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $course_name = $_POST['course_name'];
    $subject_id = $_POST['subject_id'];
    $subject_name = $_POST['subject_name'];
    $theory_hours = $_POST['theory_hours'];
    $practical_hours = $_POST['practical_hours'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $section = $_POST['section'];
    $classroom_id = $_POST['classroom_id'];
    $teacher_id = $_POST['teacher'];
    $teacher_id2 = $_POST['teacher2'];
    $teacher_id3 = $_POST['teacher3'];

    $sql = "UPDATE courses SET 
        course_name='$course_name', 
        subject_id='$subject_id', 
        subject_name='$subject_name', 
        theory_hours='$theory_hours', 
        practical_hours='$practical_hours', 
        semester='$semester', 
        academic_year='$academic_year', 
        day_of_week='$day_of_week', 
        start_time='$start_time', 
        end_time='$end_time', 
        section='$section',
        classroom_id='$classroom_id',
        teacher_id='$teacher_id',
        teacher2_id='$teacher_id2',
        teacher3_id='$teacher_id3'
        WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
     <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        body {
            font-size: 120%;
            background: #f8f8f8;
        }

        .container h1 {
            color: black;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Project การเช็คชื่อโดยการตรวจจับใบหน้า</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/learn-reactjs-2024/myproject/index.php">กรอกข้อมูลนักศึกษา</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/learn-reactjs-2024/ข้อมูลผู้สอน/index.php">กรอกข้อมูลผู้สอน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/%E0%B8%95%E0%B8%B2%E0%B8%A3%E0%B8%B2%E0%B8%87%E0%B8%AA%E0%B8%AD%E0%B8%99/index.php">ตารางสอน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/learn-reactjs-2024/หลักสูตร/index.html">หลักสูตร</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/learn-reactjs-2024/course-app/add.php">กรอกข้อมูลวิชาเรียน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/learn-reactjs-2024/room/index.html">กรอกข้อมูลห้องเรียน</a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="http://localhost/learn-reactjs-2024/startbootstrap-simple-sidebar-gh-pages/startbootstrap-simple-sidebar-gh-pages/index.html">Home</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="http://localhost/learn-reactjs-2024/%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5%E0%B8%9C%E0%B8%B9%E0%B9%89%E0%B8%AA%E0%B8%AD%E0%B8%99/display.php">เเสดงข้อมูลผู้สอน</a>
                                    <a class="dropdown-item" href="http://localhost/%E0%B8%95%E0%B8%B2%E0%B8%A3%E0%B8%B2%E0%B8%87%E0%B8%AA%E0%B8%AD%E0%B8%99/schedule.php">เเสดงข้อมูลตารางสอน</a>
                                    <a class="dropdown-item" href="http://localhost/learn-reactjs-2024/myproject/display.php">เเสดงข้อมูลนักศึกษา</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="http://localhost/learn-reactjs-2024/%E0%B8%AB%E0%B8%A5%E0%B8%B1%E0%B8%81%E0%B8%AA%E0%B8%B9%E0%B8%95%E0%B8%A3/index.php">เเสดงข้อมูลหลักสูตร</a>
                                    <a class="dropdown-item" href="http://localhost/learn-reactjs-2024/course-app/index.php">เเสดงข้อมูลวิชาเรียน</a>
                                    <a class="dropdown-item" href="http://localhost/learn-reactjs-2024/room/display_classrooms.php">เเสดงข้อมูลห้องเรียน</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
<div class="container mt-5">
    <h1 class="mb-4">Edit Course</h1>
    <form action="edit.php" method="POST" id="courseForm">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name:</label>
            <input type="text" id="course_name" name="course_name" class="form-control" value="<?php echo htmlspecialchars($row['course_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="subject_id" class="form-label">Subject ID:</label>
            <input type="text" id="subject_id" name="subject_id" class="form-control" value="<?php echo htmlspecialchars($row['subject_id']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="subject_name" class="form-label">Subject Name:</label>
            <input type="text" id="subject_name" name="subject_name" class="form-control" value="<?php echo htmlspecialchars($row['subject_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="theory_hours" class="form-label">Theory Hours:</label>
            <input type="number" id="theory_hours" name="theory_hours" class="form-control" value="<?php echo htmlspecialchars($row['theory_hours']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="practical_hours" class="form-label">Practical Hours:</label>
            <input type="number" id="practical_hours" name="practical_hours" class="form-control" value="<?php echo htmlspecialchars($row['practical_hours']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Semester:</label>
            <input type="text" id="semester" name="semester" class="form-control" value="<?php echo htmlspecialchars($row['semester']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="academic_year" class="form-label">Academic Year:</label>
            <input type="text" id="academic_year" name="academic_year" class="form-control" value="<?php echo htmlspecialchars($row['academic_year']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="day_of_week" class="form-label">Day of Week:</label>
            <select id="day_of_week" name="day_of_week" class="form-select">
                <option value="Monday" <?php if($row['day_of_week'] == 'Monday') echo 'selected'; ?>>Monday</option>
                <option value="Tuesday" <?php if($row['day_of_week'] == 'Tuesday') echo 'selected'; ?>>Tuesday</option>
                <option value="Wednesday" <?php if($row['day_of_week'] == 'Wednesday') echo 'selected'; ?>>Wednesday</option>
                <option value="Thursday" <?php if($row['day_of_week'] == 'Thursday') echo 'selected'; ?>>Thursday</option>
                <option value="Friday" <?php if($row['day_of_week'] == 'Friday') echo 'selected'; ?>>Friday</option>
                <option value="Saturday" <?php if($row['day_of_week'] == 'Saturday') echo 'selected'; ?>>Saturday</option>
                <option value="Sunday" <?php if($row['day_of_week'] == 'Sunday') echo 'selected'; ?>>Sunday</option>
            </select>
        </div>  
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time:</label>
            <input type="time" id="start_time" name="start_time" class="form-control" value="<?php echo htmlspecialchars($row['start_time']); ?>">
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">End Time:</label>
            <input type="time" id="end_time" name="end_time" class="form-control" value="<?php echo htmlspecialchars($row['end_time']); ?>">
        </div>
        <div class="mb-3">
            <label for="section" class="form-label">Section:</label>
            <input type="text" id="section" name="section" class="form-control" value="<?php echo htmlspecialchars($row['section']); ?>" required>
        </div>

        <!-- Classroom Selection -->
        <div class="mb-3">
            <label for="classroom_id" class="form-label">Classroom:</label>
            <select id="classroom_id" name="classroom_id" class="form-select" required>
                <option value="">Select Classroom</option>
                <?php while($classroom = $classrooms_result->fetch_assoc()): ?>
                    <option value="<?php echo $classroom['id']; ?>" <?php if($row['classroom_id'] == $classroom['id']) echo 'selected'; ?>>
                        <?php echo $classroom['room_number'] . ", Floor: " . $classroom['floor'] . ", Building: " . $classroom['building']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

          <!-- Teacher Selection -->
          <div class="mb-3">
            <label for="teacher" class="form-label">Teacher:</label>
            <select id="teacher" name="teacher" class="form-select" required>
                <option value="">Select Teacher</option>
                <?php while($teacher = $teachers_result->fetch_assoc()): ?>
                    <option value="<?php echo $teacher['first_name_eng'] . ' ' . $teacher['last_name_eng']; ?>" <?php if($row['teacher_id'] == $teacher['first_name_eng'] . ' ' . $teacher['last_name_eng']) echo 'selected'; ?>>
                        <?php echo $teacher['first_name_eng'] . " " . $teacher['last_name_eng']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <?php 
        // Reset result set pointer to the beginning
        $teachers_result->data_seek(0); 
        ?>

        <div class="mb-3">
            <label for="teacher2" class="form-label">Teacher:</label>
            <select id="teacher2" name="teacher2" class="form-select" required>
                <option value="">Select Teacher</option>
                <?php while($teacher = $teachers_result->fetch_assoc()): ?>
                    <option value="<?php echo $teacher['first_name_eng'] . ' ' . $teacher['last_name_eng']; ?>" <?php if($row['teacher2_id'] == $teacher['first_name_eng'] . ' ' . $teacher['last_name_eng']) echo 'selected'; ?>>
                        <?php echo $teacher['first_name_eng'] . " " . $teacher['last_name_eng']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <?php 
        // Reset result set pointer to the beginning
        $teachers_result->data_seek(0); 
        ?>

        <div class="mb-3">
            <label for="teacher3" class="form-label">Teacher:</label>
            <select id="teacher3" name="teacher3" class="form-select" required>
                <option value="">Select Teacher</option>
                <?php while($teacher = $teachers_result->fetch_assoc()): ?>
                    <option value="<?php echo $teacher['first_name_eng'] . ' ' . $teacher['last_name_eng']; ?>" <?php if($row['teacher3_id'] == $teacher['first_name_eng'] . ' ' . $teacher['last_name_eng']) echo 'selected'; ?>>
                        <?php echo $teacher['first_name_eng'] . " " . $teacher['last_name_eng']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Course</button>
    </form>
    <a href="index.php" class="btn btn-secondary mt-3">Back to Course List</a>
</div>
</div>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../startbootstrap-simple-sidebar-gh-pages\startbootstrap-simple-sidebar-gh-pages/js/scripts.js"></script>
</body>
</html>
