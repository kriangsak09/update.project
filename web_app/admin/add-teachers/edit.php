<!DOCTYPE html>
<html>
<head>
    <title>แก้ไขข้อมูลผู้สอน</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
     <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="file"],
        select,
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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
    <div class="container">
        <h1>แก้ไขข้อมูลผู้สอน</h1>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projecta";
        $id = $_GET['id'];

        // สร้างการเชื่อมต่อ
        $conn = new mysqli($servername, $username, $password, $dbname);

        // ตรวจสอบการเชื่อมต่อ
        if ($conn->connect_error) {
            die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
        }

        // ดึงข้อมูลจากฐานข้อมูล
        $sql = "SELECT * FROM teachers WHERE id='$id'";
        $result = $conn->query($sql);
        $teacher = $result->fetch_assoc();

        // ปิดการเชื่อมต่อ
        $conn->close();
        ?>
        <form action="update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">

            <label for="teacher_id">รหัสประจำตัว:</label>
            <input type="text" id="teacher_id" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>" required>

            <label for="first_name">ชื่อ:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $teacher['first_name']; ?>" required>

            <label for="last_name">นามสกุล:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $teacher['last_name']; ?>" required>

            <label for="first_name_eng">ชื่ออังกฤษ:</label>
            <input type="text" id="first_name_eng" name="first_name_eng" value="<?php echo $teacher['first_name_eng']; ?>" required>

            <label for="last_name_eng">นามสกุลอังกฤษ:</label>
            <input type="text" id="last_name_eng" name="last_name_eng" value="<?php echo $teacher['last_name_eng']; ?>" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $teacher['email']; ?>">

            <label for="faculty">คณะ:</label>
            <input type="text" id="faculty" name="faculty" value="<?php echo $teacher['faculty']; ?>" required>

            <label for="department">สาขาวิชา:</label>
            <input type="text" id="department" name="department" value="<?php echo $teacher['department']; ?>" required>

            <input type="submit" value="อัปเดต">
        </form>
    </div>
    </div>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../startbootstrap-simple-sidebar-gh-pages\startbootstrap-simple-sidebar-gh-pages/js/scripts.js"></script>
</body>
</html>
