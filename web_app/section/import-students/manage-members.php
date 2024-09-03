<!-- Include createtable_manage_members.php -->
<?php include('../component/createtable_manage_members.php'); ?>

<!-- Render Website -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student</title>
    <!-- เชื่อมโยงกับ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../styles.css">
    <link rel="stylesheet" href="./manage-member_responsive.css">
    <link rel="stylesheet" href="./0_student_styles.css">
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Page content wrapper-->
        <div class="page-content-wrapper">

            <!-- Include navigation -->
            <?php //include('../component/navigation.php'); ?>

            <!-- Menu Bar class "navbar-custom" -->
            <nav class="navbar navbar-expand-lg navbar-custom border-bottom">                
                <button class="navbar-toggler" style="margin-left: 10px;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item active"><a class="nav-link" href="javascript:window.history.back()">Back</a></li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_members); ?>">Manage Members</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_attendance); ?>">Attendance Check</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Menu Bar -->

            <!-- Page content-->
            <div class="container mt-5">
                <!-- Include header details -->
                <?php include('../component/header_details.php'); ?>   
            </div>

            <div class="container-weeks">
                <h1 class="mb-4">Manage Members</h1>
                <hr>                

                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "projecta";

                // สร้างการเชื่อมต่อกับ MySQL
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM $table_name";
                $result = $conn->query($sql);

                // ตรวจสอบว่ามันักศึกษาใน section หรือไม่?
                if ($result->num_rows > 0) {

                    // แทรก container-header-weeks ก่อนที่จะแสดงผลตาราง
                    // Container-header-weeks
                    echo "<div class='container-header-weeks'>";
                    echo "    <div class='container-count-std'></div>";
                    
                    echo "    <div class='container-form'>";
                    echo "        <h4>Import Students</h4>";
                    echo "        <form action='import.php' method='post' enctype='multipart/form-data'>";
                    echo "            <input type='file' name='excel_file' accept='.xls,.xlsx' required>";
                    echo "            <input type='hidden' name='table_name' value='" . htmlspecialchars($table_name) . "'>";
                    echo "            <button type='submit'>Import</button>";
                    echo "        </form>";
                    echo "    </div>";
                    echo "</div>";
                    // End Container-header-weeks
                    
                    echo "<h5>Student List</h5>";
                    echo "<hr>";

                    echo "<div class='table-container'>";
                    echo "<table class='table table-striped table-bordered'>";
                    echo "<thead class='thead-dark'><tr><th class='col-1'>No</th><th class='col-2'>Student Number</th><th class='col-3'>Name</th><th class='col-4'>Faculty (Branch)</th><th class='col-5'>Action</th></tr></thead>";
                    echo "<tbody>";

                    //แสดงรายชื่อนักศึกษาใน section หากมี
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['student_number'] . "</td>";
                        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                        echo "<td>" . $row['Faculty'] . " - " . $row['Field_of_study'] . "</td>";
                        // echo "<td>" . $row['Faculty'] . " (" . $row['Field_of_study'] . ") " . "</td>";
                        echo "<td>";
                        // Delete Btn
                        echo "<a href='delete-members.php?id=" . $row['id'] . "&table_name=" . $table_name . "' class='btn btn-danger custom-btn' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>";
                        echo "</td>";
                    }
                    echo "</tbody></table>";
                    echo "</div>";

                } else {
                    // การแสดงผลส่วน Import Student กรณีที่ไม่มีนักศึกษาใน section                     
                    echo "<div class='container-members-fluid mt-5'>";
                    echo "<button class='btn btn-primary' id='user-tie'>";
                    echo "<i class='fa-solid fa-user-tie'></i> <!-- Icon -->";
                    echo "</button>";
                    echo "<br>";
                    echo "Manage members to begin attendance check on the next page.";

                    // Import Members Btn มี js "click" ซึ่งทำให้เลือกไฟล์ xlsx ได้เลย   
                    echo "<div class='button-members-fluid'>";
                    echo "<button class='btn btn-primary' id='url_Import_members'>Import Members</button>"; //Button

                    //Form
                    echo "<form id='importForm' action='import.php' method='post' enctype='multipart/form-data' style='display:none;'>";
                    echo "<input type='file' id='excelFile' name='excel_file' accept='.xls,.xlsx' required>";
                    echo "<input type='hidden' name='table_name' value='" . htmlspecialchars($table_name) . "'>";
                    echo "</form>";

                    echo "</div>";

                    echo "</div>";
                    }

                $conn->close();
                ?>
            </div>
            <!-- End Page content-->

            <!-- Include footer -->
            <?php include('../component/footer_details.php'); ?>

        </div>
        <!-- End Page content wrapper--> 

    </div>
    <!-- เชื่อมโยงกับ Bootstrap JS และ jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <!-- script สำหรับเมื่อกดปุ่ม import แล้วสามารถเลือกไฟล์ได้เลย -->
    <script>
    document.getElementById('url_Import_members').addEventListener('click', function() {
        // เปิด dialog สำหรับเลือกไฟล์
        document.getElementById('excelFile').click();
    });

    document.getElementById('excelFile').addEventListener('change', function() {
        // เมื่อเลือกไฟล์แล้วให้ส่งฟอร์มทันที
        document.getElementById('importForm').submit();
    });
    </script>
</body>
</html>
