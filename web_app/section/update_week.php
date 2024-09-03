<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $week_number = isset($_POST['week_number']) ? $_POST['week_number'] : '';
    $week_date = isset($_POST['week_date']) ? $_POST['week_date'] : '';
    $on_time_time = isset($_POST['on_time_time']) ? $_POST['on_time_time'] : '';
    $late_time = isset($_POST['late_time']) ? $_POST['late_time'] : '';
    $absent_time = isset($_POST['absent_time']) ? $_POST['absent_time'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    try {
        $sql = "UPDATE weeks SET week_date = :week_date, on_time_time = :on_time_time, late_time = :late_time, absent_time = :absent_time WHERE week_number = :week_number";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':week_number', $week_number);
        $stmt->bindParam(':week_date', $week_date);
        $stmt->bindParam(':on_time_time', $on_time_time);
        $stmt->bindParam(':late_time', $late_time);
        $stmt->bindParam(':absent_time', $absent_time);
        $stmt->execute();

        echo "Record updated successfully.";
        header("Location: create-section.php?id=" . urlencode($id));
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
