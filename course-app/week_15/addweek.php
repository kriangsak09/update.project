<?php
include('../db.php');

// ดึงข้อมูลวิชาจากฐานข้อมูล
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 120%;
            background: #f8f8f8;
        }

        .container h1 {
            color: black;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Subject List</h1>
    <!-- เพิ่มฟอร์มสำหรับค้นหา -->
    <form action="../searchgroup.php" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search Course" name="search">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
    </form>
    <a href="../add.php" class="btn btn-primary mb-4">Add New Course</a>
    <ul class="list-group">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                       <div>
                           <h5 class='mb-0'><strong>Subject Name:</strong> " . $row["subject_name"] . "</h5>
                           <h5 class='mb-0'><strong>Subject ID:</strong> " . $row["subject_id"] . "</h5>
                            <p class='mb-0'><strong>Course Name:</strong> " . $row["course_name"] . "</p>
                            <p class='mb-0'><strong>Theory Hours:</strong> " . $row["theory_hours"] . "</p>
                            <p class='mb-0'><strong>Practical Hours:</strong> " . $row["practical_hours"] . "</p>
                            <p class='mb-0'><strong>Semester:</strong> " . $row["semester"] . "</p>
                            <p class='mb-0'><strong>Academic Year:</strong> " . $row["academic_year"] . "</p>
                            <p class='mb-0'><strong>Day of Week:</strong> " . $row["day_of_week"] . "</p>
                            <p class='mb-0'><strong>Start Time:</strong> " . $row["start_time"] . "</p>
                            <p class='mb-0'><strong>End Time:</strong> " . $row["end_time"] . "</p>
                            <p class='mb-0'><strong>Section:</strong> " . $row["section"] . "</p>
                          </div>
                        <div>
                            <a href='weeksubject.php?id=" . $row["id"] . "&subject_name=" . urlencode($row["subject_name"]) . "&subject_id=" . urlencode($row["subject_id"]) . "&course_name=" . urlencode($row["course_name"]) . "&theory_hours=" . urlencode($row["theory_hours"]) . "&practical_hours=" . urlencode($row["practical_hours"]) . "&semester=" . urlencode($row["semester"]) . "&academic_year=" . urlencode($row["academic_year"]) . "&day_of_week=" . urlencode($row["day_of_week"]) . "&start_time=" . urlencode($row["start_time"]) . "&end_time=" . urlencode($row["end_time"]) . "&section=" . urlencode($row["section"]) .  "' class='btn btn-info btn-sm'>View Details</a>
                        </div>
                    </li>";
            }
        } else {
            echo "<li class='list-group-item'>0 results</li>";
        }
        ?>
    </ul>
</div>
</body>
</html>

<?php
$conn->close();
?>
