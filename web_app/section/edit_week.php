<?php
session_start(); // เริ่มต้น session
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $week_number = isset($_GET['week_number']) ? $_GET['week_number'] : '';
    $table_name = isset($_GET['table_name']) ? $_GET['table_name'] : '';
    $table_weeks_name = isset($_GET['table_weeks_name']) ? strtolower($_GET['table_weeks_name']) : '';

    // Fetch existing data
    $sql = "SELECT week_number, week_date, on_time_time, late_time, absent_time FROM $table_weeks_name WHERE week_number = :week_number";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':week_number', $week_number);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

}

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
    <link rel="stylesheet" href="navigation.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="css/styles.css" rel="stylesheet" />  <!-- เเก้ path ลำดับให้ถูกต้อง -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="./edit_week_responsive.css" rel="stylesheet"/>
</head>
<style>
    .custom-btn {
    font-size: 18px !important; /* ขนาดตัวอักษร */
    padding: 15px 20px !important; /* ขนาด padding ของปุ่ม */
    border-radius: 8px !important; /* ขอบมนของปุ่ม */
    width: 100px !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    text-align: center; /* จัดตัวอักษรให้อยู่ตรงกลางแนวนอน */
    margin: 2px !important;
}
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
        /* table custom */
        .table-container {
            width: 100%;  /* กำหนดความกว้างของตาราง */
        }
        table th {
            font-size: 9px;
            padding: 8px; /* กำหนด padding ภายในเซลล์ */
            border: 1px solid #ddd; /* เส้นขอบของเซลล์ */
            text-align: center; /* จัดข้อความให้อยู่ซ้าย */
            vertical-align: top; /* จัดข้อความให้อยู่ด้านบนของเซลล์ */
            text-decoration: none; /* ลบการขีดเส้นใต้ */
        }
        table td {
            font-size: 9px;
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
            width: 160px; /* Date */
        }
        th.col-3 {
            width: 100px; /* P time */
        }
        th.col-4 {
            width: 100px; /* L time */
        }
        th.col-5 {
            width: 100px; /* A time */
        }
        th.col-6 {
            width: 60px; /* Action */
        }

        .footer {
            font-size: 12px;
        }
        .custom-btn {
    font-size: 18px !important; /* ขนาดตัวอักษร */
    padding: 15px 100px !important; /* ขนาด padding ของปุ่ม */
    border-radius: 8px !important; /* ขอบมนของปุ่ม */
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    text-align: center; /* จัดตัวอักษรให้อยู่ตรงกลางแนวนอน */
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
.form-label {
    text-align: left; /* จัดตัวอักษรให้อยู่ทางด้านซ้าย */
    display: block; /* ทำให้ label ครอบคลุมทั้งบรรทัด */
    margin-bottom: 8px; /* เพิ่มระยะห่างด้านล่าง (ถ้าต้องการ) */
    color: black;
}
</style>
<body>
    <div class="d-flex" id="wrapper">
     <!-- Include Setting navigation -->
     <?php include 'component/setting_nav.php';?>

      <!-- Include navigation -->
      <?php include './component/navigation.php';?>

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
        </ul>
    </div>
</nav>
<!-- End Menu Bar -->


<div class="container">
        <h1>Edit Week Information</h1>
        <!-- Display week number for reference -->
        <div class="alert alert-info" role="alert">
            Editing Week Number: <?php echo htmlspecialchars($week_number); ?>
        </div>
        <form action="update_week.php" method="POST">
            <input type="hidden" name="week_number" value="<?php echo htmlspecialchars($week_number); ?>">
            <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($table_name); ?>">
            <input type="hidden" name="table_weeks_name" value="<?php echo htmlspecialchars($table_weeks_name); ?>">
            <div class="mb-3">
                <label for="week_date" class="form-label">Week Date</label>
                <input type="date" class="form-control" id="week_date" name="week_date" value="<?php echo htmlspecialchars($data['week_date']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="on_time_time" class="form-label">On Time</label>
                <input type="time" class="form-control" id="on_time_time" name="on_time_time" value="<?php echo htmlspecialchars($data['on_time_time']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="late_time" class="form-label">Late Time</label>
                <input type="time" class="form-control" id="late_time" name="late_time" value="<?php echo htmlspecialchars($data['late_time']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="absent_time" class="form-label">Absent Time</label>
                <input type="time" class="form-control" id="absent_time" name="absent_time" value="<?php echo htmlspecialchars($data['absent_time']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary custom-btn">Update</button>
            <a href="javascript:window.history.back()" class="btn btn-secondary custom-btn">Cancel</a>
        </form>
    </div>
    <?php include './component/footer_details.php';?>

</div>
</div>
</div>
            <!-- End Page content-->

            <!-- Include footer -->        
        
        <!-- End Page content wrapper-->
    
    <!-- เชื่อมโยงกับ Bootstrap JS และ jQuery -->
    <script src="./js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
