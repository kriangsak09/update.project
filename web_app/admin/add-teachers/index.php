<?php
session_start();
require "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Manage Student</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="../style.css">

    <!-- Menu left Sidebar -->
    <link href="./css/styles.css" rel="stylesheet"/>
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
                <h1 class="mt-3">Manage-Teacher</h1>
                <?php if (isset($_SESSION["success"])) { ?>
                    <div class="alert alert-success">
                        <?php 
                            echo $_SESSION["success"];
                            unset($_SESSION["success"]);
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION["error"])) { ?>
                    <div class="alert alert-danger">
                        <?php 
                            echo $_SESSION["error"];
                            unset($_SESSION["error"]);
                        ?>
                    </div>
                <?php } ?>
                <hr>
                <br>
                <form action="./submit.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="teacher_id">รหัสประจำตัว:</label>
                        <input type="text" id="teacher_id" class="form-control" name="teacher_id" required>
                    </div>

                    <div class="mb-3">
                        <label for="first_name">ชื่อ:</label>
                        <input type="text" id="first_name" class="form-control" name="first_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="last_name">นามสกุล:</label>
                        <input type="text" id="last_name" class="form-control" name="last_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="first_name_eng">ชื่ออังกฤษ:</label>
                        <input type="text" id="first_name_eng" class="form-control" name="first_name_eng" required>
                    </div>

                    <div class="mb-3">
                        <label for="last_name_eng">นามสกุลอังกฤษ:</label>
                        <input type="text" id="last_name_eng" class="form-control" name="last_name_eng" required>
                    </div>

                    <div class="mb-3">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" class="form-control" name="email">
                    </div>

                    <div class="mb-3">
                        <label for="faculty">คณะ:</label>
                        <input type="text" id="faculty" class="form-control" name="faculty" required>
                    </div>

                    <div class="mb-3">
                        <label for="department">สาขาวิชา:</label>
                        <input type="text" id="department" class="form-control" name="department" required>
                    </div>

                    <button type="submit" class="btn btn-success">Upload</button>
                
                </form>
                <br>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scriptss.js"></script>
</body>
</html>
