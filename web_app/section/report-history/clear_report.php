<?php
session_start();
include('config.php');

$table_report = preg_replace("/[^a-zA-Z_]/", "", "report_daily_" . $_SESSION['subject_name']);

$table_name = isset($_POST['table_name']) ? $_POST['table_name'] : '';
$table_weeks_name = isset($_POST['table_weeks_name']) ? $_POST['table_weeks_name'] : '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM $table_report";
if ($conn->query($sql) === TRUE) {
    echo "All records deleted successfully";
} else {
    echo "Error deleting records: " . $conn->error;
}

$conn->close();

$url_report = './summary_report.php?table_name=' . urlencode($table_name) . '&table_weeks_name=' . urlencode($table_weeks_name);
// Redirect back to the report page
header("Location: $url_report");
exit;
?>
