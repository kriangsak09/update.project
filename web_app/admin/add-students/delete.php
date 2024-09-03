<?php
session_start();
require "config.php";

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ไม่มีรหัสนักศึกษา";
    header("Location: std_list.php");
    exit();
}

$id = $_GET['id'];

try {
    // ลบข้อมูลจากฐานข้อมูล
    $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
    $stmt->execute([$id]);

    // ตรวจสอบการลบข้อมูล
    if ($stmt->rowCount() > 0) {
        $_SESSION['success'] = "ลบข้อมูลนักศึกษาเรียบร้อยแล้ว";
    } else {
        $_SESSION['error'] = "ไม่สามารถลบข้อมูลนักศึกษาได้ หรือไม่พบข้อมูล";
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "เกิดข้อผิดพลาดในการลบข้อมูล: " . $e->getMessage();
}

// รีไดเร็กต์ไปยังหน้า index.php
header("Location: index.php");
exit();
?>
