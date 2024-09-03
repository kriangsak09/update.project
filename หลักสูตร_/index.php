<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .edit-btn, .delete-btn {
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            margin-right: 5px;
        }
        .edit-btn:hover, .delete-btn:hover {
            background-color: #00608E;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>View Courses</h2>

    <!-- เพิ่มแบบฟอร์มสำหรับค้นหาข้อมูล -->
    <form action="search_courses.php" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <?php
    // โค้ด PHP สำหรับแสดงข้อมูลตาราง
    ?>
</div>

<div class="container">
    <h2>View Courses</h2>

    <?php
    // เชื่อมต่อกับฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projecta";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // คำสั่ง SQL สำหรับดึงข้อมูล
    $sql = "SELECT * FROM courses_ca";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Course Name</th><th>Description</th><th>Duration</th><th>Instructor</th><th>Start Date</th><th>End Date</th><th>Faculty</th><th>Department</th><th>Action</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['course_name']."</td>";
            echo "<td>".$row['description']."</td>";
            echo "<td>".$row['duration']."</td>";
            echo "<td>".$row['instructor']."</td>";
            echo "<td>".$row['start_date']."</td>";
            echo "<td>".$row['end_date']."</td>";
            echo "<td>".$row['faculty']."</td>";
            echo "<td>".$row['department']."</td>";
            echo "<td><a href='edit_course.php?id=".$row['course_id']."' class='edit-btn'>Edit</a> <a href='delete_course.php?id=".$row['course_id']."' class='delete-btn'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</div>

</body>
</html>
