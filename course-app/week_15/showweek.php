<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Week Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        caption {
            font-size: 1.5em;
            margin: 10px 0;
        }
    </style>
</head>
<body>

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

// ดึงข้อมูลจากตาราง
$sql = "SELECT week_number, week_date FROM weeks";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<caption>ตารางสัปดาห์</caption>";
    echo "<tr><th>ลำดับสัปดาห์</th><th>วัน/เดือน/ปี</th></tr>";

    // แสดงข้อมูลในแต่ละแถว
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["week_number"] . "</td>";
        echo "<td>" . $row["week_date"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>ไม่มีข้อมูล</p>";
}

$conn->close();
?>

</body>
</html>
