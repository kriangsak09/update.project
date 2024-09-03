<?php
session_start(); // เริ่มต้น session
include('config.php'); // เชื่อมต่อฐานข้อมูล

// นำข้อมูลจาก $_SESSION มาใส่ในตัวแปร
$id = $_SESSION['id'];
$subject_name = $_SESSION['subject_name'];
$subject_id = $_SESSION['subject_id'];
$classroom_id = $_SESSION['classroom_id'];
$theory_hours = $_SESSION['theory_hours'];
$practical_hours = $_SESSION['practical_hours'];
$semester = $_SESSION['semester'];
$academic_year = $_SESSION['academic_year'];
$day_of_week = $_SESSION['day_of_week'];
$start_time = $_SESSION['start_time'];
$end_time = $_SESSION['end_time'];
$section = $_SESSION['section'];

$table_name = isset($_GET['table_name']) ? strtolower($_GET['table_name']) : '';
$table_weeks_name = isset($_GET['table_weeks_name']) ? strtolower($_GET['table_weeks_name']) : '';

$url_members = './import-students/manage-members.php?table_name=' . urlencode($table_name) . '&subject_id=' . urlencode($subject_id);
$url_attendance = './attendance-check.php?table_name=' . urlencode($table_name) . '&table_weeks_name=' . urlencode($table_weeks_name);
$url_report = './report-history/summary_report.php?table_name=' . urlencode($table_name) . '&table_weeks_name=' . urlencode($table_weeks_name);
$url_home = './index.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Section Details</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    /* Small devices (Phone 0-576px) */
    @media (max-width: 576px) {
        /* Header details */
        .container {
            max-width: 415px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: start;
        }
        /* 15 weeks */
        .container-schedule {
            max-width: 415px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: start;
        }
        /* Content 15 weeks */
        .container-weeks {
            max-width: 415px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        /* table custom */
        .table-container {
            width: 100%;  /* กำหนดความกว้างของตาราง */
        }
        table th {
            font-size: 8px;
            padding: 8px; /* กำหนด padding ภายในเซลล์ */
            border: 1px solid #ddd; /* เส้นขอบของเซลล์ */
            text-align: center; /* จัดข้อความให้อยู่ซ้าย */
            vertical-align: top; /* จัดข้อความให้อยู่ด้านบนของเซลล์ */
            text-decoration: none; /* ลบการขีดเส้นใต้ */
        }    
        table td {
            font-size: 7px;
            padding: 6px; /* กำหนด padding ภายในเซลล์ */
            border: 1px solid #ddd; /* เส้นขอบของเซลล์ */
            text-align: center; /* จัดข้อความให้อยู่ซ้าย */
            vertical-align: top; /* จัดข้อความให้อยู่ด้านบนของเซลล์ */
            text-decoration: none; /* ลบการขีดเส้นใต้ */
        } 
        td {
            word-wrap: break-word; /* ตัดคำเมื่อข้อความยาวเกินขนาดที่กำหนด */
            white-space: normal; /* อนุญาตให้ตัดบรรทัดในข้อความ */
            overflow: hidden; /* ซ่อนข้อความที่ยาวเกิน */
        }
        th.col-1 {
            width: 20px; /* Week */
        }
        th.col-2 {
            width: 150px; /* Date */
        }
        th.col-3 {
            width: 160px; /* P time */
        }
        th.col-4 {
            width: 160px; /* L time */
        }
        th.col-5 {
            width: 160px; /* A time */
        } 
        th.col-6 {
            width: 60px; /* Action */
        } 
        /* Action Btn */
        .custom-btn {
            font-size: 8px;
            width:  38px;
            padding: 3px 6px;
            margin: 3px;
        }
        .footer {
            font-size: 12px;
        }
    } 

    /*Medium devices (tablets, 576px and up)*/
    @media (min-width: 576px) { 
        /* Header details */
        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: start;
        }
        /* 15 weeks */
        .container-schedule {
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: start;
        }
        /* Content 15 weeks */
        .container-weeks {
            max-width: 700px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        /* table custom */
        .table-container {
            width: 100%;  /* กำหนดความกว้างของตาราง */
        }
        table th {
            font-size: 11px;
            padding: 8px; /* กำหนด padding ภายในเซลล์ */
            border: 1px solid #ddd; /* เส้นขอบของเซลล์ */
            text-align: center; /* จัดข้อความให้อยู่ซ้าย */
            vertical-align: top; /* จัดข้อความให้อยู่ด้านบนของเซลล์ */
            text-decoration: none; /* ลบการขีดเส้นใต้ */
        }    
        table td {
            font-size: 10px;
            padding: 6px; /* กำหนด padding ภายในเซลล์ */
            border: 1px solid #ddd; /* เส้นขอบของเซลล์ */
            text-align: center; /* จัดข้อความให้อยู่ซ้าย */
            vertical-align: top; /* จัดข้อความให้อยู่ด้านบนของเซลล์ */
            text-decoration: none; /* ลบการขีดเส้นใต้ */
        } 
        td {
            word-wrap: break-word; /* ตัดคำเมื่อข้อความยาวเกินขนาดที่กำหนด */
            white-space: normal; /* อนุญาตให้ตัดบรรทัดในข้อความ */
            overflow: hidden; /* ซ่อนข้อความที่ยาวเกิน */
        }
        th.col-1 {
            width: 20px; /* Week */
        }
        th.col-2 {
            width: 150px; /* Date */
        }
        th.col-3 {
            width: 160px; /* P time */
        }
        th.col-4 {
            width: 160px; /* L time */
        }
        th.col-5 {
            width: 160px; /* A time */
        } 
        th.col-6 {
            width: 100px; /* Action */
        } 
        /* Action Btn */
        .custom-btn {
            font-size: 10px;
            width:  50px;
            padding: 4px 8px;
            margin: 3px;
        }
    }
    /*Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) { 
        .navbar-custom .nav-link {
            color: rgb(46, 46, 46);
            padding-bottom: 5px;
            position: relative;
        }

        .navbar-custom .nav-link::after {
            content: "";
            display: block;
            width: 0;
            height: 2px;
            height: 4px; /* ปรับความหนาของเส้น */
            background-color: #7124ff; /* สีของเส้นใต้ */
            position: absolute;
            bottom: 0;
            left: 0;
            transition: width 0.3s ease;
        }
        .navbar-custom .nav-link:hover::after,
        .navbar-custom .nav-link.active::after {
            width: 100%;
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
        .container-schedule {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: start;
        }
        .container-weeks {
            max-width: 1000px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        /* table custom */
        .table-container {
            width: 100%;  /* กำหนดความกว้างของตาราง */
        }
        table th {
            font-size: 14px;
            padding: 8px; /* กำหนด padding ภายในเซลล์ */
            border: 1px solid #ddd; /* เส้นขอบของเซลล์ */
            text-align: center; /* จัดข้อความให้อยู่ซ้าย */
            vertical-align: top; /* จัดข้อความให้อยู่ด้านบนของเซลล์ */
            text-decoration: none; /* ลบการขีดเส้นใต้ */
        }    
        table td {
            font-size: 14px;
            padding: 6px; /* กำหนด padding ภายในเซลล์ */
            border: 1px solid #ddd; /* เส้นขอบของเซลล์ */
            text-align: center; /* จัดข้อความให้อยู่ซ้าย */
            vertical-align: top; /* จัดข้อความให้อยู่ด้านบนของเซลล์ */
            text-decoration: none; /* ลบการขีดเส้นใต้ */
        } 
        td {
            word-wrap: break-word; /* ตัดคำเมื่อข้อความยาวเกินขนาดที่กำหนด */
            white-space: normal; /* อนุญาตให้ตัดบรรทัดในข้อความ */
            overflow: hidden; /* ซ่อนข้อความที่ยาวเกิน */
        }
        th.col-1 {
            width: 20px; /* Week */
        }
        th.col-2 {
            width: 150px; /* Date */
        }
        th.col-3 {
            width: 160px; /* P time */
        }
        th.col-4 {
            width: 160px; /* L time */
        }
        th.col-5 {
            width: 160px; /* A time */
        } 
        th.col-6 {
            width: 100px; /* Action */
        } 
        /* Action Btn */
        .custom-btn {
            font-size: 14px; /* ขนาดฟอนต์ */
            padding: 8px 16px; /* ขนาด padding ของปุ่ม */
            display: inline-block;
            width: 80px; /* กำหนดความกว้างของปุ่ม */
            text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
            line-height: 1.5; /* ความสูงของบรรทัดเพื่อให้ปุ่มมีความสูงเท่ากัน */
            margin: 3px;
        }
    } 
</style>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Page content wrapper-->
        <div class="page-content-wrapper">

            <!-- Include navigation -->
            <?php //include('./component/navigation.php'); ?>

            <!-- Menu Bar class "navbar-custom" -->
            <nav class="navbar navbar-expand-lg navbar-custom border-bottom">                
                <button class="navbar-toggler" style="margin-left: 10px;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item active"><a class="nav-link" href="javascript:window.history.back()">Back</a></li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_members); ?>">Manage members</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_attendance); ?>">Attendance check</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_report); ?>">Report daily</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Menu Bar -->

            <!-- Page content-->
            <div class="container mt-5">

                <!-- Include header details -->
                <?php include('./component/header_details.php'); ?>   
            </div>

            <div class="container-schedule" style="text-align: center;">
                <h2>15 Weeks schedule</h2>
            </div>


            <div class="container-weeks">

                <?php
                    // เชื่อมต่อฐานข้อมูลใหม่
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // ตรวจสอบการเชื่อมต่อ
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // ดึงข้อมูลจากตาราง $table_weeks_name
                    $sql = "SELECT week_number, week_date, on_time_time, late_time, absent_time FROM $table_weeks_name";
                    $result = $conn->query($sql);

                    // แสดงข้อมูลตารางสัปดาห์
                    if ($result->num_rows > 0) {
                        echo "<div class='table-container'>";
                        echo "<table class='table table-striped'>";
                        echo "<caption>Schedule plan</caption>";
                        echo "<thead><tr><th class='col-1'>Week</th><th class='col-2'>Date</th><th class='col-3'>Present time</th><th class='col-4'>Late time</th><th class='col-5'>Absent time</th><th class='col-6'>Action</th></tr></thead>";
                        echo "<tbody>";

                        while ($row = $result->fetch_assoc()) {
                            $week_number = htmlspecialchars($row["week_number"]);
                            $week_date = htmlspecialchars($row["week_date"]);
                            $on_time_time = htmlspecialchars($row["on_time_time"]);
                            $late_time = htmlspecialchars($row["late_time"]);
                            $absent_time = htmlspecialchars($row["absent_time"]);
                            $target_page = "week_details.php?week_number=" . urlencode($week_number) . "&id=" . urlencode($id) . "&subject=" . urlencode($subject_name) . '&table_name=' . urlencode($table_name) . '&table_weeks_name=' . urlencode($table_weeks_name);
                            $edit_page = "edit_week.php?week_number=" . urlencode($week_number) . "&id=" . urlencode($id) . '&table_name=' . urlencode($table_name) . '&table_weeks_name=' . urlencode($table_weeks_name);

                            echo "<tr>";
                            echo "<td>$week_number</td>";
                            echo "<td>$week_date</td>";
                            echo "<td>$on_time_time</td>";
                            echo "<td>$late_time</td>";
                            echo "<td>$absent_time</td>";
                            echo "<td><a href='$edit_page' class='btn btn-warning custom-btn'>Edit</a><a href='$target_page' class='btn btn-primary custom-btn'>Check</a></td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                    } else {
                        echo "<p>ไม่มีข้อมูล</p>";
                    }

                    $conn->close();
                ?>
            </div>
            <!-- End Page content-->

            <!-- Include footer -->
            <?php include('./component/footer_details.php'); ?>
            
        </div>
        <!-- End Page content wrapper-->
    </div>

    <!-- เชื่อมโยงกับ Bootstrap JS และ jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
