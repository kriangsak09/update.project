<?php
require "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Students List</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="../style.css">

    <!-- Menu left Sidebar -->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6oCoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #ffffff; /* สีพื้นหลังของทั้งหน้าเว็บ */
        }        
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
                <h1 class="mt-3">Student lists</h1>
                <hr> 

                <!-- ฟอร์มค้นหา -->
                <form action="std_list.php" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="ค้นหาข้อมูลนักศึกษา" name="search">
                        <button class="btn btn-outline-secondary" id="search_btn" type="submit">ค้นหา</button>
                        <a href="./std_list.php" class="btn btn-outline-danger" id="clear_btn">ล้างคำค้นหา</a>  
                    </div>
                </form>
                <!-- ฟอร์มสำหรับเลือกนักศึกษาและ Export -->
                <form action="export_students.php" method="POST">

                    <div class="container-btn">
                        <!-- ปุ่มเลือกทั้งหมด -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="select_all">
                            <label class="form-check-label" for="select_all">Select all</label>
                        </div>   

                        <!-- Export Btn -->
                        <div class="input-group mb-3">
                            <button class="btn btn-success" id="export_btn" type="submit">Export Excel</button>
                        </div>
                    </div>
                    
                    <?php
                        // จำนวนข้อมูลต่อหน้า
                        $limit = 9;

                        // คำนวณหน้าปัจจุบัน
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        // ตรวจสอบว่ามีการส่งคำขอค้นหาหรือไม่
                        if (isset($_GET['search'])) {
                            $search = '%' . $_GET['search'] . '%';
                            $stmt = $conn->prepare("SELECT * FROM images WHERE first_name LIKE :search OR last_name LIKE :search OR student_number LIKE :search OR Faculty LIKE :search OR Field_of_study LIKE :search LIMIT $limit OFFSET $offset");
                            $stmt->bindParam(':search', $search);
                            $stmt->execute();
                        } else {
                            // ถ้าไม่มีคำขอค้นหา ดึงข้อมูลทั้งหมด
                            $stmt = $conn->prepare("SELECT * FROM images LIMIT $limit OFFSET $offset");
                            $stmt->execute();
                        }

                        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // ดึงจำนวนข้อมูลทั้งหมดสำหรับการแบ่งหน้า
                        $total_stmt = $conn->query("SELECT COUNT(*) FROM images");
                        $total_records = $total_stmt->fetchColumn();
                        $total_pages = ceil($total_records / $limit);

                        if ($students) {
                            echo "<div class='row'>";
                            foreach ($students as $student) {
                                echo "<div class='col-md-4'>";
                                echo '<div class="card mb-4">';
                                echo '<img class="card-img-top" src="data:image/jpeg;base64,' . base64_encode($student['image']) . '" alt="Uploaded image" />';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($student['first_name']) . ' ' . htmlspecialchars($student['last_name']) . '</h5>';
                                echo '<p class="card-text"><strong>Student Number:</strong> ' . htmlspecialchars($student['student_number']) . '</p>';
                                echo '<p class="card-text"><strong>Faculty:</strong> ' . htmlspecialchars($student['Faculty']) . '</p>';
                                echo '<p class="card-text"><strong>Branch:</strong> ' . htmlspecialchars($student['Field_of_study']) . '</p>';
                                echo '<a href="edit.php?id=' . htmlspecialchars($student['id']) . '" class="btn btn-warning" id="edit_btn">Edit</a>';
                                echo '<a href="delete.php?id=' . htmlspecialchars($student['id']) . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this record?\');">Delete</a>';
                                echo '<div class="form-check mt-3">';
                                echo '<input class="form-check-input" type="checkbox" name="selected_students[]" value="' . htmlspecialchars($student['id']) . '">';
                                echo '<label class="form-check-label">Select</label>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo "</div>";
                            }
                            echo "</div>";
                        } else {
                            echo "<p>ไม่พบนักศึกษาที่ตรงกับการค้นหา</p>";
                        }

                        // สร้างลิงก์การแบ่งหน้า
                        echo '<nav>';
                        echo '<ul class="pagination">';

                        // ปุ่มย้อนกลับ
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . '">Previous</a></li>';
                        }

                        // ลูปแสดงตัวเลขหน้า
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . '">' . $i . '</a></li>';
                        }

                        // ปุ่มถัดไป
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . '">Next</a></li>';
                        }

                        echo '</ul>';
                        echo '</nav>';
                    ?>
                </form>
                <script>
                    document.getElementById('select_all').addEventListener('change', function() {
                        var checkboxes = document.querySelectorAll('input[name="selected_students[]"]');
                        for (var checkbox of checkboxes) {
                            checkbox.checked = this.checked;
                        }
                    });
                </script>            
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
                });
            }
        });
    </script>
</body>
</html>
