<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projecta";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ฟังก์ชันสำหรับการเพิ่มวันที่ในแต่ละสัปดาห์
function addWeeks($startDate, $weeksToAdd) {
    $dateArray = [];
    for ($i = 0; $i < $weeksToAdd; $i++) {
        $date = date('Y-m-d', strtotime("+$i week", strtotime($startDate)));
        $dateArray[] = $date;
    }
    return $dateArray;
}

$startDate = '2024-07-01'; // วันที่เริ่มต้น
$weeksToAdd = 15; // จำนวนสัปดาห์ที่ต้องการเพิ่ม

$weekDates = addWeeks($startDate, $weeksToAdd);

// ตรวจสอบว่ามีข้อมูลในตารางมากกว่า 0 หรือไม่
$result = $conn->query("SELECT COUNT(*) AS count FROM weeks");
$row = $result->fetch_assoc();
$currentCount = $row['count'];

// หากยังมีข้อมูลไม่ถึง 15 สัปดาห์ ให้เพิ่มข้อมูลใหม่
if ($currentCount < $weeksToAdd) {
    $stmt = $conn->prepare("INSERT INTO weeks (week_number, week_date, on_time_time, late_time, absent_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $weekNumber, $weekDate, $onTimeTime, $lateTime, $absentTime);

    foreach ($weekDates as $index => $weekDate) {
        $weekNumber = $index + 1;
        if ($weekNumber == 1) {
            // กำหนดเวลาสำหรับสัปดาห์ที่ 1
            $onTimeTime = '08:00:00';  // เวลาเช็คชื่อที่ไม่สาย
            $lateTime = '09:00:00';    // เวลาเช็คชื่อที่สาย
            $absentTime = '00:00:00';  // เวลาเช็คชื่อที่ขาดเรียน
        } else {
            // กำหนดเวลาสำหรับสัปดาห์อื่น ๆ
            $onTimeTime = '08:00:00';  // เวลาตัวอย่างสำหรับสัปดาห์อื่น
            $lateTime = '09:00:00';    // เวลาตัวอย่างสำหรับสัปดาห์อื่น
            $absentTime = '00:00:00';  // เวลาตัวอย่างสำหรับสัปดาห์อื่น
        }

        $stmt->execute();
    }

    $stmt->close();
    echo "Data inserted successfully!";
} else {
    echo "Data already up to date!";
}

$conn->close();
?>
