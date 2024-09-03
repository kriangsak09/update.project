<?php
session_start(); // start session
require "config.php"; // connect mysql

// สร้างฟังก์ชันบีบอัดภาพ
function compressImage($file) {
    $imageContent = file_get_contents($file); // อ่านเนื้อหาของไฟล์ภาพ
    $sourceImage = imagecreatefromstring($imageContent); // สร้างภาพจากสตริงที่มีข้อมูลภาพ
    ob_start(); //เริ่มการบัฟเฟอร์เอาท์พุท
    imagejpeg($sourceImage, null, 80); // 80% quality บีบอัดภาพเป็น JPEG ด้วยคุณภาพ 80%
    $compressedImageContent = ob_get_clean(); // ดึงข้อมูลภาพที่ถูกบีบอัดออกจากบัฟเฟอร์
    imagedestroy($sourceImage); // ทำลายภาพที่สร้างขึ้นเพื่อเคลียร์หน่วยความจำ
    return $compressedImageContent; // คืนค่าผลลัพธ์ (รูปภาพที่ถูกบีบอัดแล้ว)
}

// ตรวจสอบและจัดการการอัพโหลดภาพ
if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $image = $_FILES["image"]["tmp_name"];
    $image1 = $_FILES["image1"]["tmp_name"];
    $image2 = $_FILES["image2"]["tmp_name"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $student_number = $_POST["student_number"];
    $Faculty = $_POST["Faculty"];
    $Field_of_study = $_POST["Field_of_study"];

    // เรียกใช้ฟังก์ชั่น compressImage เพื่อใช้บีบอัดภาพ
    $imgContent = compressImage($image);
    $imgContent1 = compressImage($image1);
    $imgContent2 = compressImage($image2);

    // เพิ่มข้อมูลลงในฐานข้อมูล
    $stmt = $conn->prepare("INSERT INTO images (image, image1, image2, first_name, last_name, student_number, Faculty, Field_of_study) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$imgContent, $imgContent1, $imgContent2, $first_name, $last_name, $student_number, $Faculty, $Field_of_study]);

    if ($stmt) {
        $_SESSION["success"] = "Image uploaded successfully.";
        header("Location: index.php");
    } else {
        $_SESSION["error"] = "Failed to upload image. Please try again.";
        header("Location: index.php");
    }
} else {
    $_SESSION["error"] = "Please select an image file to upload.";
    header("Location: index.php");
}
?>
