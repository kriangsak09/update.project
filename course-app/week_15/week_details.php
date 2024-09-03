<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projecta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get week_number from query string
$week_number = isset($_GET['week_number']) ? intval($_GET['week_number']) : 0;

// Get id from query string (if available)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch data for the selected week
$sql = "SELECT week_number, week_date, on_time_time, late_time, absent_time FROM weeks WHERE week_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $week_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $week_date = $row["week_date"];
    $on_time_time = $row["on_time_time"];
    $late_time = $row["late_time"];
    $absent_time = $row["absent_time"];
} else {
    die("Week not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Week Details</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h1>รายละเอียดของสัปดาห์ที่ <?php echo htmlspecialchars($week_number); ?></h1>
        <p>วัน/เดือน/ปี: <?php echo htmlspecialchars($week_date); ?></p>
        <p>เวลาที่ไม่สาย: <?php echo htmlspecialchars($on_time_time); ?></p>
        <p>เวลาที่สาย: <?php echo htmlspecialchars($late_time); ?></p>
        <p>เวลาที่ขาดเรียน: <?php echo htmlspecialchars($absent_time); ?></p>
        <a href="weeksubject.php?id=<?php echo urlencode($id); ?>" class="btn btn-secondary">Back to Course Details</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9nK59GQKTxW9fElC5n7xS2vjtBlz5W0Q4yt7BzpXk06g4UB9v8V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-cv5xK+8I2kFfbRgI+Q7Xckn2Sm6hf6cH9PjTZhxDSz69iXzRzTjS8/aHpjkPI5Wf1" crossorigin="anonymous"></script>
</body>
</html>
