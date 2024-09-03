<?php
include('db.php');

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // คำสั่ง SQL สำหรับการค้นหาที่เชื่อมตาราง classrooms และ teachers ด้วย
    $sql = "SELECT c.*, 
                   cl.room_number, cl.floor, cl.building, 
                   t1.first_name as first_name1, t1.last_name as last_name1, t1.teacher_id as teacher_id1,
                   t2.first_name as first_name2, t2.last_name as last_name2, t2.teacher_id as teacher_id2,
                   t3.first_name as first_name3, t3.last_name as last_name3, t3.teacher_id as teacher_id3
            FROM courses c
            LEFT JOIN classrooms cl ON c.classroom_id = cl.id
            LEFT JOIN teachers t1 ON c.teacher_id = t1.id
            LEFT JOIN teachers t2 ON c.teacher2_id = t2.id
            LEFT JOIN teachers t3 ON c.teacher3_id = t3.id
            WHERE c.subject_name LIKE '%$search%' 
               OR c.subject_id LIKE '%$search%' 
               OR c.course_name LIKE '%$search%' 
               OR c.theory_hours LIKE '%$search%' 
               OR c.practical_hours  LIKE '%$search%' 
               OR c.semester LIKE '%$search%' 
               OR c.academic_year LIKE '%$search%' 
               OR c.day_of_week LIKE '%$search%' 
               OR c.start_time LIKE '%$search%' 
               OR c.end_time LIKE '%$search%' 
               OR c.section LIKE '%$search%' 
               OR cl.room_number LIKE '%$search%' 
               OR c.teacher_id LIKE '%$search%' 
               OR c.teacher2_id LIKE '%$search%' 
               OR c.teacher3_id LIKE '%$search%'";
    $result = $conn->query($sql);
}

// ตรวจสอบว่ามีการส่งค่าค้นหามาหรือไม่
if (isset($_GET['search'])) {
    // รับค่าการค้นหา
    $search = $_GET['search'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
     <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        body {
            font-size: 120%;
            background: #f8f8f8;
        }

        /* เปลี่ยนสีพื้นหลังของหัวข้อเป็นสีฟ้า */
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
    <h1 class="mb-4">Course List</h1>
    <form action="search.php" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search Course" name="search">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
    </form>
    <a href="index.php" class="btn btn-primary mb-4">Back to Course List</a>
    <ul class="list-group">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                        <div>
                            <h5 class='mb-0'><strong>Subject Name:</strong> " . $row["subject_name"] . "</h5>
                            <p class='mb-0'><strong>Subject_id:</strong> " . $row["subject_id"] . "</p>
                            <p class='mb-0'><strong>Course_name:</strong> " . $row["course_name"] . "</p>
                            <p class='mb-0'><strong>Theory_hours:</strong> " . $row["theory_hours"] . "</p>
                            <p class='mb-0'><strong>Practical_hours:</strong> " . $row["practical_hours"] . "</p>
                            <p class='mb-0'><strong>semester:</strong> " . $row["semester"] . "</p>
                            <p class='mb-0'><strong>academic_year:</strong> " . $row["academic_year"] . "</p>
                            <p class='mb-0'><strong>day_of_week:</strong> " . $row["day_of_week"] . " <strong>Start Time:</strong>" . $row["start_time"] . " <strong>End Time:</strong>" . $row["end_time"] . "</p>
                            <p class='mb-0'><strong>section:</strong> " . $row["section"] . "</p>
                            <p class='mb-0'><strong>Classroom:</strong> " . $row["room_number"] . $row["floor"] . $row["building"] .  "</p>
                            <p class='mb-0'><strong>Teacher:</strong> " . $row["teacher_id"] . "</p>
                            <p class='mb-0'><strong>Teacher 2:</strong> " . $row["teacher2_id"] . "</p>
                            <p class='mb-0'><strong>Teacher 3:</strong> " . $row["teacher3_id"] . "</p>";


                echo "</div>
                        <div>
                            <a href='edit.php?id=" . $row["id"] . "' class='btn btn-secondary btn-sm me-2'>Edit</a>
                            <a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Delete</a>
                        </div>
                    </li>";
            }
        } else {
            echo "<li class='list-group-item'>No results found</li>";
        }
        ?>
    </ul>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
</body>
</html>

<?php
$conn->close();
} else {
    // ถ้าไม่มีการค้นหา ให้เปลี่ยนเส้นทางกลับไปยังหน้า index.php
    header("Location: index.php");
    exit();
}
?>
