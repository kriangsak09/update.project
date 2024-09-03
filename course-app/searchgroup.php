<?php
include('db.php');

// ตรวจสอบว่ามีการส่งค่าค้นหามาหรือไม่
if (isset($_GET['search'])) {
    // รับค่าการค้นหา
    $search = $_GET['search'];

    // ค้นหาข้อมูลในฐานข้อมูล
    $sql = "SELECT * FROM courses WHERE subject_name LIKE '%$search%' OR course_code LIKE '%$search%' OR category LIKE '%$search%' OR credits LIKE '%$search%' OR status LIKE '%$search%' OR day_of_week LIKE '%$search%' OR start_time LIKE '%$search%' OR end_time LIKE '%$search%' OR section LIKE '%$search%'";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 120%;
            background: #f8f8f8;
        }

        /* เปลี่ยนสีพื้นหลังของหัวข้อเป็นสีฟ้า */
        .container h1 {
            color: black;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Search Results</h1>
    <form action="searchgroup.php" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search Course" name="search">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
    </form>
    <a href="index.php" class="btn btn-primary mb-4">Back to Course List</a>
    <ul class="list-group">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                        <div>
                           <h5 class='mb-0'><strong>Subject Name:</strong> " . $row["subject_name"] . "</h5>
                            <p class='mb-0'><strong>Course Code:</strong> " . $row["course_code"] . "</p>
                            <p class='mb-0'><strong>Category:</strong> " . $row["category"] . "</p>
                            <p class='mb-0'><strong>Credits:</strong> " . $row["credits"] . " credits</p>
                            <p class='mb-0'><strong>Status:</strong> " . $row["status"] . "</p> <!-- แสดงข้อมูล Status -->";

                // ตรวจสอบว่ามีข้อมูลเพิ่มเติมหรือไม่
                if ($row["status"] == "Open") {
                    echo "<div>
                            <p class='mb-0'><strong>Day of Week:</strong> " . $row["day_of_week"] . "</p>
                            <p class='mb-0'><strong>Start Time:</strong> " . $row["start_time"] . "</p>
                            <p class='mb-0'><strong>End Time:</strong> " . $row["end_time"] . "</p>
                            <p class='mb-0'><strong>Section:</strong> " . $row["section"] . "</p>
                          </div>";
                }

                echo "</div>
                        <div>
                            <a href='details.php?id=" . $row["id"] . "&subject_name=" . urlencode($row["subject_name"]) . "&course_code=" . urlencode($row["course_code"]) . "&category=" . urlencode($row["category"]) . "&credits=" . urlencode($row["credits"]) . "&status=" . urlencode($row["status"]) . "&day_of_week=" . urlencode($row["day_of_week"]) . "&start_time=" . urlencode($row["start_time"]) . "&end_time=" . urlencode($row["end_time"]) . "&section=" . urlencode($row["section"]) .  "' class='btn btn-info btn-sm'>View Details</a>
                        </div>
                    </li>";
            }
        } else {
            echo "<li class='list-group-item'>No results found</li>";
        }
        ?>
    </ul>
</div>
</body>
</html>

<?php
$conn->close();
} else {
    // ถ้าไม่มีการค้นหา ให้เปลี่ยนเส้นทางกลับไปยังหน้า index.php
    header("Location: index.php");
    exit();
}
?>
