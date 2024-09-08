<?php
session_start();
include('config.php');

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

$table_report = preg_replace("/[^a-zA-Z_]/", "", "report_daily_" . $subject_name);

$url_members = '../import-students/manage-members.php?table_name=' . urlencode($table_name) . '&subject_id=' . urlencode($subject_id);
$url_attendance = '../attendance-check.php?table_name=' . urlencode($table_name) . '&table_weeks_name=' . urlencode($table_weeks_name);
$url_report = './summary_report.php?table_name=' . urlencode($table_name) . '&table_weeks_name=' . urlencode($table_weeks_name);
$url_home = '../index.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Section Details</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="../../section/navigation.css">
    <link href="../css/styles.css" rel="stylesheet" />
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
        /* Report Attendance */
        .container-schedule {
            max-width: 415px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: start;
        }
        /* Content */
        .container-weeks {
            max-width: 415px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* เพิ่มเข้ามาจาก navigation.php */
        #sidebar-wrapper {
            width: 300px;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
            position: fixed;
            height: 100%;
            top: 0;
            left: -250px; /* Hide by default */
            transition: all 0.3s ease; /* กำหนดความเร็ว เมนูตอนเลื่อน */
            overflow-y: auto; /* เพิ่มคุณสมบัติ overflow */
        }

        #Nofounds_report {
            display: flex;
            justify-content: center;
            align-items: center;

            height: 150px;      
        }
        /* Clear Btn */
        #clear-btn {
            width: 115px;
            padding: 20px;
            border-radius: 10px;
            text-align: start;
            margin-left: auto;
            margin-right: 0;
            display: block;
        }
        .clear-btn {
            width:  90px;
            padding: 2px 4px;
            margin: 3px;
            text-align: center;
        }
        .full-width {
            width: 100%;
        }
        /* Topic */
        th {
            font-size: 8.5px;
            text-align: center;
            vertical-align: top;
        }
        /* details */
        td {
            font-size: 10px;
            text-align: center;
        }
        /* Action Btn */
        .custom-btn {
            font-size: 9px;
            width:  40px;
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
        /* Report Attendance */
        .container-schedule {
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: start;
        }
        /* Content */
        .container-weeks {
            max-width: 700px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        #Nofounds_report {
            display: flex;
            justify-content: center;
            align-items: center;

            height: 150px;      
        }
        /* Clear Btn */
        #clear-btn {
            width: 100px;
            padding: 20px;
            border-radius: 10px;
            text-align: start;
            margin-left: auto;
            margin-right: 0;
            display: block;
        }
        /* Topic */
        th {
            font-size: 15px;
            text-align: center;
            vertical-align: top;
        }
        /* details */
        td {
            font-size: 15px;
            text-align: center;
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
        #Nofounds_report {
            display: flex;
            justify-content: center;
            align-items: center;

            height: 150px;      
        }
        #clear-btn {
            max-width: 180px;
            padding: 20px;
            border-radius: 10px;
            text-align: start;
            margin-left: auto;
            margin-right: 0;
            display: block;
        }
    }
</style>
<style>
/* CSS Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* การตั้งค่าพื้นฐาน */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    color: #343a40;
    margin: 0;
    padding: 0;
}
caption {
    caption-side: top;
    font-weight: bold;
    margin: 10px 0;
}

h1 {
    font-weight: 200;
    font-family: 'Arial', sans-serif;
}
/* การตั้งค่าคอนเทนเนอร์หลัก */
.container {
    max-width: 1000px;
    margin: 50px auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    text-align: start;
}

#wrapper {
    display: flex;
    width: 100%;
 /* เอา height to full viewport height ออก */
}

.nav-item {
    margin-left: 15px; /* ระยะห่างระหว่างแต่ละปุ่ม */
}
.page-content-wrapper {
    flex: 1;
}

/* การตั้งค่าคอนเทนเนอร์ Form */
.container-form {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}
/* ฟอร์มอัปโหลด */
form {
    display: flex;
    flex-direction: column;
}

input[type="file"] {
    margin-bottom: 20px;
}
button[type="submit"] {
    background-color: #007bff;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}
button[type="submit"]:hover {
    background-color: #0056b3;
}

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

#sidebarToggle {
    background: transparent; /* ทำให้พื้นหลังของปุ่มเป็นใส */
    border: none; /* เอาขอบออกจากปุ่ม */
    padding: 0; /* เอาระยะห่างภายในปุ่มออก */
    cursor: pointer; /* เปลี่ยนเคอร์เซอร์เมื่อวางบนปุ่ม */
}

#sidebarToggle i {
    font-size: 24px; /* กำหนดขนาดของไอคอน (ปรับขนาดตามต้องการ) */
    color: #000; /* กำหนดสีของไอคอน (เปลี่ยนตามต้องการ) */
}

/* เพิ่ม hover effect ถ้าต้องการ */
#sidebarToggle:hover {
    background: rgba(0, 0, 0, 0.1); /* เพิ่มพื้นหลังสีอ่อนเมื่อเลื่อนเมาส์มาบนปุ่ม */
}

.footer {
    width: 100%;
    text-align: center;
    padding: 30px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}
 /* เพิ่มเข้ามาในนี้จาก navigation.css  */
.list-group-item {
    display: flex;
    align-items: center;
    font-size: 1.5rem;
    padding: 10px 15px;
    border: none;
    border-radius: 0;
    background: transparent; /* Transparent background */
    color: #000; /* Black text */
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
}

.list-group-item i {
    margin-right: 10px ;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 15px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-group-item-action:hover {
    background-color: #f0f0f0; /* เปลี่ยนสีพื้นหลังเมื่อเมาส์เลื่อนมาที่ปุ่ม */
    transform: scale(1.20); /* ขยายปุ่มเล็กน้อย */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* เพิ่มเงาให้ปุ่ม */
    border-radius: 6%;
}
.btn-container-2 {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-circle {
    display: flex;
    align-items: center;
    padding: 10px;
    text-decoration: none;
    color: black;
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
    border-radius: 8px; /* เพิ่มมุมมนให้ปุ่ม */
}

.btn-circle:hover {
    background-color: #f0f0f0; /* เปลี่ยนสีพื้นหลังเมื่อเมาส์เลื่อนมาที่ปุ่ม */
    transform: scale(1.20); /* ขยายปุ่มเล็กน้อย */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* เพิ่มเงาให้ปุ่ม */
}
</style>
<body>
    <div class="d-flex" id="wrapper">
         <!-- Include Setting navigation -->
     <?php include '../component/setting_nav.php';?>


            <?php include('../component/navigation.php'); ?>

            <!-- Menu Bar class "navbar-custom" -->
            <nav class="navbar navbar-expand-lg navbar-custom border-bottom">                
                <button class="navbar-toggler" style="margin-left: 10px;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_members); ?>">Manage members</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_attendance); ?>">Attendance check</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_report); ?>">Report daily</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url_home); ?>">Home</a>
                        </li>                    
                    </ul>
                </div>
            </nav>

            <div class="container mt-5">
                <?php include('../component/header_details.php'); ?>
            </div>

            <div class="container-schedule" style="text-align: center;">
                <h2>Report Attendance</h2>
            </div>

            <div class="container-weeks">
                <?php
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // ตรวจสอบการมีอยู่ของตาราง
                    $table_check_sql = "SHOW TABLES LIKE '$table_report'";
                    $table_check_result = $conn->query($table_check_sql);


                    if ($table_check_result->num_rows == 0) {
                        echo "<div id='Nofounds_report'><p class='text-center'>No founds Your Attendance Report.<br>Please! take a Attendance Checking and Save your results.</p></div>";
                    } else {

                        echo "<form id='clear-btn' action='clear_report.php' method='post' onsubmit='return confirm(\"Are you sure you want to clear report history?\");'>";
                        echo "<button type='submit' class='btn btn-danger clear-btn'>Clear</button>";
                        echo "<input type='hidden' name='table_name' value='$table_name'>";
                        echo "<input type='hidden' name='table_weeks_name' value='$table_weeks_name'>";
                        echo "</form>";
                                
                        // Pagination
                        $limit = 10; // จำนวนแถวต่อหน้า
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        $total_sql = "SELECT COUNT(*) FROM $table_report";
                        $total_result = $conn->query($total_sql);
                        $total_rows = $total_result->fetch_row()[0];
                        $total_pages = ceil($total_rows / $limit);

                        $sql = "SELECT week_number, week_date, upload_time, total_faces_on_time, names_on_time, total_faces_late_time, names_late_time, total_faces_absent_time, names_absent_time FROM $table_report LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<div class='full-width'>";
                            echo "<table class='table table-striped'>";
                            echo "<caption>Attendance History Table</caption>";
                            echo "<thead style='text-align: center';><tr><th>Attendance Week</th><th>Attendance Date/Time</th><th>Present group</th><th>Late group</th><th>Absent group</th><th>Total</th><th></th></tr></thead>";
                            echo "<tbody>";

                            while ($row = $result->fetch_assoc()) {
                                $week_number = htmlspecialchars($row["week_number"]);
                                $upload_time = htmlspecialchars($row["upload_time"]);

                                $total_faces_on_time = htmlspecialchars($row["total_faces_on_time"]);
                                $total_faces_late_time = htmlspecialchars($row["total_faces_late_time"]);
                                $total_faces_absent_time = htmlspecialchars($row["total_faces_absent_time"]);
                                $total_faces_group = $total_faces_on_time + $total_faces_late_time + $total_faces_absent_time;
                                
                                $names_on_time = htmlspecialchars($row["names_on_time"]);
                                $names_late_time = htmlspecialchars($row["names_late_time"]);
                                $names_absent_time = htmlspecialchars($row["names_absent_time"]);
                                
                                // Convert names lists to arrays
                                $names_on_time_array = explode(",", $names_on_time);
                                $names_late_time_array = explode(",", $names_late_time);
                                $names_absent_time_array = explode(",", $names_absent_time);
                                
                                // Create a unique ID for each row
                                $row_id = uniqid();
                                
                                echo "<tr>";
                                echo "<td style='text-align: center;'>$week_number</td>";
                                echo "<td style='text-align: center;'>$upload_time</td>";
                                echo "<td style='text-align: center;'>$total_faces_on_time</td>";
                                echo "<td style='text-align: center;'>$total_faces_late_time</td>";
                                echo "<td style='text-align: center;'>$total_faces_absent_time</td>";
                                echo "<td style='text-align: center;'>$total_faces_group</td>";
                                echo "<td style='text-align: center;'>";
                                echo "<button class='btn btn-info custom-btn' data-bs-toggle='modal' data-bs-target='#modal-$row_id'>More details</button>";
                                echo "</td>";
                                echo "</tr>";
                                
                                // Add modal for each row
                                echo "<div class='modal fade' id='modal-$row_id' tabindex='-1' aria-labelledby='modalLabel-$row_id' aria-hidden='true'>";
                                echo "    <div class='modal-dialog'>";
                                echo "        <div class='modal-content'>";
                                echo "            <div class='modal-header'>";
                                echo "                <h5 class='modal-title' id='modalLabel-$row_id'>Details for Week $week_number</h5>";
                                echo "                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                echo "            </div>";
                                echo "            <div class='modal-body'>";
                                echo "                <h6>On Time:</h6>";
                                foreach ($names_on_time_array as $name) {
                                    if ($name != "") {
                                        echo "<p>$name</p>";
                                    } else {
                                        echo "<p>Not found in On Time category.</p>";
                                    }
                                }
                                echo "                <h6>Late:</h6>";
                                foreach ($names_late_time_array as $name) {
                                    if ($name != "") {
                                        echo "<p>$name</p>";
                                    } else {
                                        echo "<p>Not found in Late Time category.</p>";
                                    }
                                }
                                echo "                <h6>Absent:</h6>";
                                foreach ($names_absent_time_array as $name) {
                                    if ($name != "") {
                                        echo "<p>$name</p>";
                                    } else {
                                        echo "<p>Not found in Absent Time category.</p>";
                                    }
                                }
                                echo "            </div>";
                                echo "            <div class='modal-footer'>";
                                echo "                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                                echo "            </div>";
                                echo "        </div>";
                                echo "    </div>";
                                echo "</div>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";

                             // Pagination
                            echo "<nav aria-label='Page navigation'>";
                            echo "<ul class='pagination justify-content-center'>";
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active = ($i == $page) ? "active" : "";
                                echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
                            }
                            echo "</ul>";
                            echo "</nav>";

                        } else {
                            echo "<p class='text-center'>Havn't an Attendance History.</p>";
                        }
                    }
                    $conn->close();
                ?>
            </div>

            <!-- Include footer -->
            <?php include('../component/footer_details.php'); ?>

        </div>
    </div>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <!-- Script for toggle Menu -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var sidebarToggle = document.getElementById('sidebarToggle');
    var body = document.body;
    var wrapper = document.getElementById('wrapper');
    var overlay = document.getElementById('overlay');

    // Toggle sidebar visibility when button is clicked
    sidebarToggle.addEventListener('click', function () {
        wrapper.classList.toggle('toggled');
        overlay.style.display = wrapper.classList.contains('toggled') ? 'block' : 'none';
    });

    // Hide sidebar and overlay when overlay is clicked
    overlay.addEventListener('click', function () {
        body.classList.remove('sb-sidenav-toggled');
        wrapper.classList.remove('toggled');
        overlay.style.display = 'none';
    })
});

</script>
</body>
</html>
