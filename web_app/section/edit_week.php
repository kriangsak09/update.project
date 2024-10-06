<?php
include('config.php');

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Week</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./edit_week_responsive.css" rel="stylesheet"/>
    <style>
        .footer {
            width: 100%;
            text-align: center;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }    
    </style>
</head>
<body>
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

    <?php include('./component/footer_details.php'); ?>

</body>
</html>
