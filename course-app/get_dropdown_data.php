<?php
include('config.php');

try {
    // Check connection
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Query to get distinct teachers
    $teachersStmt = $conn->query("SELECT DISTINCT teacher_id AS value, teacher_name AS text FROM courses");
    $teachers = $teachersStmt->fetchAll(PDO::FETCH_ASSOC);

    // Query to get distinct academic years
    $academicYearsStmt = $conn->query("SELECT DISTINCT academic_year AS value FROM courses");
    $academicYears = $academicYearsStmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Prepare data for JSON response
    $response = [
        'teachers' => $teachers,
        'academicYears' => array_map(function($year) {
            return ['value' => $year, 'text' => $year];
        }, $academicYears)
    ];

    // Set header and send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    // Handle errors and send error response
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    // Handle general errors and send error response
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
