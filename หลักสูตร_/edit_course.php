<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projecta";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่า course_id มาจากหน้า view_courses.php หรือไม่
if(isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // คำสั่ง SQL สำหรับดึงข้อมูลหลักสูตรที่ต้องการแก้ไข
    $sql = "SELECT * FROM courses_ca WHERE course_id = $course_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Course not found";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}

// ตรวจสอบว่ามีการส่งค่าฟอร์มมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์มแก้ไข
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $instructor = $_POST['instructor'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];

    // คำสั่ง SQL สำหรับอัพเดตข้อมูล
    $sql = "UPDATE courses_ca SET course_name='$course_name', description='$description', duration='$duration', instructor='$instructor', start_date='$start_date', end_date='$end_date', faculty='$faculty', department='$department' WHERE course_id=$course_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        // เปลี่ยนเส้นทางไปยังหน้า index.php
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
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
        form {
            display: grid;
            gap: 10px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        textarea {
            resize: vertical;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Course</h2>

    <form action="" method="post">
        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" name="course_name" value="<?php echo $row['course_name']; ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required><?php echo $row['description']; ?></textarea>

        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" value="<?php echo $row['duration']; ?>" required>

        <label for="instructor">Instructor:</label>
        <input type="text" id="instructor" name="instructor" value="<?php echo $row['instructor']; ?>" required>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $row['start_date']; ?>" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $row['end_date']; ?>" required>

        <label for="faculty">Faculty:</label>
        <input type="text" id="faculty" name="faculty" value="<?php echo $row['faculty']; ?>" required>

        <label for="department">Department:</label>
        <input type="text" id="department" name="department" value="<?php echo $row['department']; ?>" required>

        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
