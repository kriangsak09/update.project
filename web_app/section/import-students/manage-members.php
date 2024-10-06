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
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../styles.css">
    <link rel="stylesheet" href="../../section/navigation.css">
    <link rel="stylesheet" href="./manage-member_responsive.css">
    <link rel="stylesheet" href="./0_student_styles.css">
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Include Setting navigation -->
        <?php include('../component/setting_nav.php'); ?>

        <!-- Include navigation -->
        <?php include('../component/navigation.php'); ?>

        <!-- Page content wrapper-->
        <div class="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <button class="btn" id="sidebarToggle" style="border: none; background-color: transparent; padding: 0;">
                            <i class="fas fa-bars" style="font-size: 28px; color: black;"></i>
                        </button>
                        <span style="font-size: 1.3rem; margin-left: 20px; color: black;">Classroom</span>
                    </div>
                </div>
            </nav>

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

                    // Show members content 
                    echo "<form id='deleteForm' action='delete-multiple-members.php' method='POST'>"; // เริ่มฟอร์มที่สองสำหรับตาราง
                    echo "<div class='del-mul-btn-container'>"; // เริ่ม div ที่ครอบปุ่มเพื่อจัดให้อยู่ชิดขวา
                    echo "<button type='submit' class='del_mul-btn'>Delete</button>"; // ปุ่มลบหลายรายการ
                    echo "</div>"; // ปิด div ที่ครอบปุ่ม

                    echo "<div class='table-container'>";
                    echo "<table class='table table-striped table-bordered'>";
                    echo "<thead class='thead-dark'><tr><th class='col-1'>Select all<br><input type='checkbox' id='select-all' class='mt-2'></th><th class='col-1'>No</th><th class='col-2'>Student Number</th><th class='col-3'>Name</th><th class='col-4'>Faculty (Branch)</th></tr></thead>";
                    echo "<tbody>";

                    // แสดงรายชื่อนักศึกษาใน section หากมี
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='ids[]' value='" . $row['id'] . "'></td>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['student_number'] . "</td>";
                        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                        echo "<td>" . $row['Faculty'] . " - " . $row['Field_of_study'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                    echo "</div>";

                    echo "<input type='hidden' name='table_name' value='$table_name'>";
                    echo "</form>"; // ปิดฟอร์ม
                    // End members content 

                    echo "<br>";
                    echo "<div class='text-center'>";
                    echo "<a class='btn btn-primary next-btn' href='$url_attendance'>Next</a>";
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

                    <!-- Bootstrap Modal for confirmation -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete the selected students?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmDeleteBtn">Delete</button>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- Bootstrap Modal for no selection alert -->
                    <div class="modal fade" id="noSelectionModal" tabindex="-1" aria-labelledby="noSelectionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="noSelectionModalLabel">No Selection</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Please select at least one student to delete.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                    <script>
                    document.getElementById('select-all').onclick = function() {
                        var checkboxes = document.getElementsByName('ids[]');
                        for (var checkbox of checkboxes) {
                            checkbox.checked = this.checked;
                        }
                    }

                    document.getElementById('deleteForm').onsubmit = function(event) {
                        event.preventDefault(); // หยุดการส่งฟอร์มโดยอัตโนมัติ
                        var checkboxes = document.getElementsByName('ids[]');
                        var selected = false;
                        for (var checkbox of checkboxes) {
                            if (checkbox.checked) {
                                selected = true;
                                break;
                            }
                        }

                        if (!selected) {
                            // แสดง modal แจ้งเตือนกรณีไม่มีการเลือก
                            var noSelectionModal = new bootstrap.Modal(document.getElementById('noSelectionModal'));
                            noSelectionModal.show();
                            return false;
                        }

                        // แสดง modal ยืนยันการลบ
                        var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                        confirmationModal.show();
                    }

                    // เมื่อคลิกปุ่ม Delete ใน modal
                    document.getElementById('confirmDeleteBtn').onclick = function() {
                        document.getElementById('deleteForm').submit(); // ส่งฟอร์ม
                    }
                    </script>
                    
            <!-- Include footer -->
            <?php include('../component/footer_details.php'); ?>

        </div>
        <!-- End Page content wrapper--> 

    </div>
    <!-- เชื่อมโยงกับ Bootstrap JS และ jQuery -->
    <script src="../js/scripts.js"></script>
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
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('wrapper').classList.toggle('toggled');
        });
    </script>
</body>
</html>
