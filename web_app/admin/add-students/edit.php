<?php
session_start();
require "config.php";

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ไม่มีรหัสนักศึกษา";
    header("Location: display.php");
    exit();
}

$id = $_GET['id'];

// ดึงข้อมูลจาก DB โดย หาจาก id
$stmt = $conn->prepare("SELECT * FROM images WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    $_SESSION['error'] = "ไม่พบนักศึกษาที่ต้องการ";
    header("Location: display.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $student_number = $_POST["student_number"];
    $Faculty = $_POST["Faculty"];
    $Field_of_study = $_POST["Field_of_study"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = $_FILES["image"]["tmp_name"];
        $image1 = $_FILES["image1"]["tmp_name"];
        $image2 = $_FILES["image2"]["tmp_name"];
        $imgContent = file_get_contents($image);
        $imgContent1 = file_get_contents($image1);
        $imgContent2 = file_get_contents($image2);
        $stmt = $conn->prepare("UPDATE images SET image = ?, image1 = ?, image2 = ?, first_name = ?, last_name = ?, student_number = ?, Faculty = ?, Field_of_study = ? WHERE id = ?");
        $stmt->execute([$imgContent, $imgContent1, $imgContent2, $first_name, $last_name, $student_number, $Faculty, $Field_of_study, $id]);
        
        $_SESSION['success'] = "อัปเดตข้อมูลและรหัสใบหน้าเสร็จสิ้น";
        header("Location: std_list.php");
        exit();
    
    } else {
        $stmt = $conn->prepare("UPDATE images SET first_name = ?, last_name = ?, student_number = ?, Faculty = ?, Field_of_study = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $student_number, $Faculty, $Field_of_study, $id]);

        $_SESSION['success'] = "อัปเดตข้อมูลและรหัสใบหน้าเสร็จสิ้น";
        header("Location: std_list.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Student Edit</title>

    <!-- Menu left Sidebar -->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: start;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Include sidebar -->
        <?php include('./sidebar.php'); ?>   

        <!-- Page content wrapper-->
        <div id="page-content-wrapper">

            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Menu</button>
                </div>
            </nav>
            <!-- End Top navigation-->

            <!-- Page content-->
            <div class="container mt-5">
                <h1 class="mt-3">Edit-Student</h1>
                <hr>
                <br>
                <form action="edit.php?id=<?php echo $student['id']; ?>" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="upload" class="form-label">Upload image</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="mb-3">
                        <label for="upload" class="form-label">Upload image</label>
                        <input type="file" class="form-control" name="image1">
                    </div>

                    <div class="mb-3">
                        <label for="upload" class="form-label">Upload image</label>
                        <input type="file" class="form-control" name="image2">
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="inputstudent_number" class="form-label">รหัสนักศึกษา</label>
                        <input type="text" id="inputstudent_number" class="form-control" name="student_number" value="<?php echo htmlspecialchars($student['student_number']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="inputfirst_name" class="form-label">ชื่อ</label>
                        <input type="text" id="inputfirst_name" class="form-control" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="inputlast_name" class="form-label">นามสกุล</label>
                        <input type="text" id="inputlast_name" class="form-control" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="inputFaculty" class="form-label">คณะ</label>
                        <input type="text" id="inputFaculty" class="form-control" name="Faculty" value="<?php echo htmlspecialchars($student['Faculty']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="inputField_of_study" class="form-label">สาขาวิชา</label>
                        <input type="text" id="inputField_of_study" class="form-control" name="Field_of_study" value="<?php echo htmlspecialchars($student['Field_of_study']); ?>">
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
                <br>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scriptss.js"></script>
</body>
</html>
