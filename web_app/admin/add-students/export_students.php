<?php
require "config.php"; // เรียกใช้งานการเชื่อมต่อฐานข้อมูล
require "vendor/autoload.php"; // เรียกใช้งานไลบรารี PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// ตรวจสอบว่ามีการส่งข้อมูล ID นักศึกษามาหรือไม่
if (isset($_POST['selected_students']) && !empty($_POST['selected_students'])) {
    $selected_students = $_POST['selected_students'];

    // สร้าง Spreadsheet ใหม่
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // ตั้งค่าชื่อคอลัมน์ใน Sheet
    // $sheet->setCellValue('A1', 'Student Number');
    // $sheet->setCellValue('B1', 'First Name');
    // $sheet->setCellValue('C1', 'Last Name');
    // $sheet->setCellValue('D1', 'Faculty');
    // $sheet->setCellValue('E1', 'Field of Study');

    // ดึงข้อมูลนักศึกษาที่ถูกเลือกจากฐานข้อมูล
    $placeholders = rtrim(str_repeat('?,', count($selected_students)), ',');
    $stmt = $conn->prepare("SELECT * FROM images WHERE id IN ($placeholders)");
    $stmt->execute($selected_students);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // เติมข้อมูลนักศึกษาใน Sheet
    $row = 1;
    foreach ($students as $student) {
        $sheet->setCellValue('A' . $row, $student['student_number']);
        $sheet->setCellValue('B' . $row, $student['first_name']);
        $sheet->setCellValue('C' . $row, $student['last_name']);
        $sheet->setCellValue('D' . $row, $student['Faculty']);
        $sheet->setCellValue('E' . $row, $student['Field_of_study']);
        $row++;
    }

    // ตั้งค่าหัวข้อของไฟล์เพื่อส่งออกเป็นไฟล์ Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="students_list.xlsx"');

    // เขียนข้อมูลลงในไฟล์และส่งออก
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
} else {
    // ถ้าไม่มีการเลือกนักศึกษาใดๆ ให้แสดงข้อความแจ้งเตือน
    echo "No students were selected for export.";
    exit();
}
