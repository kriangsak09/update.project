<?php
include('config.php');

$id = $_GET['id'];

if (!is_numeric($id)) {
    die("Invalid ID");
}
    $course_name = isset($_GET['course_name']) ? $_GET['course_name'] : '';
    $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
    $subject_name = isset($_GET['subject_name']) ? $_GET['subject_name'] : '';
    $theory_hours = isset($_GET['theory_hours']) ? $_GET['theory_hours'] : '';
    $practical_hours = isset($_GET['practical_hours']) ? $_GET['practical_hours'] : '';
    $semester = isset($_GET['semester']) ? $_GET['semester'] : '';
    $academic_year = isset($_GET['academic_year']) ? $_GET['academic_year'] : '';
    $day_of_week = isset($_GET['day_of_week']) ? $_GET['day_of_week'] : '';
    $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
    $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
    $section = isset($_GET['section']) ? $_GET['section'] : '';
    
$table_name = "course_" . $id;

$sql_select = "SELECT * FROM $table_name";

// สร้างตารางใหม่ถ้ายังไม่มีตารางนี้ในฐานข้อมูล
$sql_create_table = "CREATE TABLE IF NOT EXISTS $table_name (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image LONGBLOB NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    student_number VARCHAR(20) NOT NULL,
    Faculty VARCHAR(255) NOT NULL,
    Field_of_study VARCHAR(255) NOT NULL
)";

try {
    // ทำการสร้างตารางใหม่
    $conn->exec($sql_create_table);
    echo "Table $table_name created successfully. ";

    // ใช้ JOIN เพื่อดึงข้อมูลจากตาราง classrooms และ teachers
    $sql_select = "SELECT c.*, cl.room_number, cl.floor, cl.building, t.first_name as teacher_first_name, t.last_name as teacher_last_name, t.teacher_id
                   FROM courses c
                   LEFT JOIN classrooms cl ON c.classroom_id = cl.id
                   LEFT JOIN teachers t ON c.teacher_id = t.id
                   WHERE c.id = :id";
    $stmt = $conn->prepare($sql_select);
    $stmt->execute(['id' => $id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Simple Sidebar - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Project การเช็คชื่อโดยการตรวจจับใบหน้า</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/myproject/index.php">กรอกข้อมูลนักศึกษา</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5%E0%B8%9C%E0%B8%B9%E0%B9%89%E0%B8%AA%E0%B8%AD%E0%B8%99/index.php">กรอกข้อมูลผู้สอน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/%E0%B8%95%E0%B8%B2%E0%B8%A3%E0%B8%B2%E0%B8%87%E0%B8%AA%E0%B8%AD%E0%B8%99/index.php">ตารางสอน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/%E0%B8%AB%E0%B8%A5%E0%B8%B1%E0%B8%81%E0%B8%AA%E0%B8%B9%E0%B8%95%E0%B8%A3/index.html">หลักสูตร</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/course-app/add.php">ข้อมูลวิชาเรียน</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="http://localhost/room/index.html">ข้อมูลห้องเรียน</a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="display.php">เเสดงข้อมูลนักศึกษา</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="http://localhost/%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5%E0%B8%9C%E0%B8%B9%E0%B9%89%E0%B8%AA%E0%B8%AD%E0%B8%99/display.php">เเสดงข้อมูลผู้สอน</a>
                                    <a class="dropdown-item" href="http://localhost/%E0%B8%95%E0%B8%B2%E0%B8%A3%E0%B8%B2%E0%B8%87%E0%B8%AA%E0%B8%AD%E0%B8%99/schedule.php">เเสดงข้อมูลตารางสอน</a>
                                    <a class="dropdown-item" href="http://localhost/myproject/display.php">เเสดงข้อมูลนักศึกษา</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="http://localhost/%E0%B8%AB%E0%B8%A5%E0%B8%B1%E0%B8%81%E0%B8%AA%E0%B8%B9%E0%B8%95%E0%B8%A3/index.php">เเสดงข้อมูลหลักสูตร</a>
                                    <a class="dropdown-item" href="http://localhost/course-app/index.php">เเสดงข้อมูลวิชาเรียน</a>
                                    <a class="dropdown-item" href="http://localhost/room/display_classrooms.php">เเสดงข้อมูลห้องเรียน</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container mt-4">
                <h1><?php echo htmlspecialchars($subject_name); ?></h1>
                <hr>
                <!-- ฟอร์มค้นหา -->
                <form action="details.php" method="GET" class="mb-3">
                    <!-- เพิ่ม input hidden สำหรับส่งค่า 'id' ไปยัง details.php -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($subject_id); ?>">
                    <input type="hidden" name="subject_name" value="<?php echo htmlspecialchars($subject_name); ?>">
                    <input type="hidden" name="course_name" value="<?php echo htmlspecialchars($course_name); ?>">
                    <input type="hidden" name="theory_hours" value="<?php echo htmlspecialchars($theory_hours); ?>">
                    <input type="hidden" name="practical_hours" value="<?php echo htmlspecialchars($practical_hours); ?>">
                    <input type="hidden" name="semester" value="<?php echo htmlspecialchars($semester); ?>">
                    <input type="hidden" name="academic_year" value="<?php echo htmlspecialchars($academic_year); ?>">
                    <input type="hidden" name="day_of_week" value="<?php echo htmlspecialchars($day_of_week); ?>">
                    <input type="hidden" name="start_time" value="<?php echo htmlspecialchars($start_time); ?>">
                    <input type="hidden" name="end_time" value="<?php echo htmlspecialchars($end_time); ?>">
                    <input type="hidden" name="section" value="<?php echo htmlspecialchars($section); ?>">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="ค้นหาข้อมูลนักศึกษา" name="search">
                        <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                    </div>
                </form>

                <div class="container mt-5">
                    <h1 class="mb-4">Course Details :  <?php echo htmlspecialchars($subject_name); ?></h1>
                    <!-- แสดงข้อมูลรายละเอียดของคอร์ส -->
                    <p>รายละเอียดของคอร์สที่มี ID: <?php echo htmlspecialchars($id); ?></p>
                    <p>Subject Name: <?php echo htmlspecialchars($subject_name); ?></p>
                    <p>Course Name: <?php echo htmlspecialchars($course_name); ?></p>
                    <p>theory_hours: <?php echo htmlspecialchars($theory_hours); ?></p>
                    <p>practical_hours: <?php echo htmlspecialchars($practical_hours); ?></p>
                    <p>semester: <?php echo htmlspecialchars($semester); ?></p>
                    <p>academic_year: <?php echo htmlspecialchars($academic_year); ?></p>
                    <p>day_of_week: <?php echo htmlspecialchars($day_of_week); ?></p>
                    <p>start_time: <?php echo htmlspecialchars($start_time); ?></p>
                    <p>end_time: <?php echo htmlspecialchars($end_time); ?></p>
                    <p>section: <?php echo htmlspecialchars($section); ?></p>
                    <!-- Classroom Details -->
                    <p>Classroom : room number: <?php echo htmlspecialchars($course['room_number']); ?> Floor: <?php echo htmlspecialchars($course['floor']); ?> Building: <?php echo htmlspecialchars($course['building']); ?></p>
                    <!-- Teacher Details -->
                    <p>Teacher : <?php echo htmlspecialchars($course['teacher_first_name'] . ' ' . $course['teacher_last_name']); ?> Teacher ID: <?php echo htmlspecialchars($course['teacher_id']); ?></p>

                    <div id="selected-students"></div>

                    <?php
                        // ตรวจสอบว่ามีการส่งคำขอค้นหาหรือไม่
                        if (isset($_GET['search'])) {
                            $search = '%' . $_GET['search'] . '%';
                            $stmt = $conn->prepare("SELECT * FROM images WHERE first_name LIKE ? OR last_name LIKE ? OR student_number LIKE ? OR Faculty LIKE ? OR Field_of_study LIKE ?");
                            $stmt->execute([$search, $search, $search, $search, $search]);
                            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } else {
                            // ถ้าไม่มีคำขอค้นหา ดึงข้อมูลทั้งหมด
                            $stmt = $conn->query("SELECT * FROM images");
                            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        }

                        if ($students) {
                            echo "<div class='row'>";
                            echo "<form id='student-form' action='process_selected_students.php' method='POST'>";
                            echo "<div class='row'>";
                            echo "<button type='submit' class='btn btn-primary mb-3'>บันทึกข้อมูลที่เลือก</button>";
                            echo "<button type='button' id='select-all' class='btn btn-secondary mb-3 me-2'>เลือกทั้งหมด</button>";
                            echo "<button type='button' id='deselect-all' class='btn btn-secondary mb-3'>ยกเลิกเลือกทั้งหมด</button>";

                            foreach($students as $student) {
                                echo "<div class='col-md-4'>";
                                echo '<div class="card mb-4">';
                                echo '<img class="card-img-top" src="data:image/jpeg;base64,' . base64_encode($student['image']) . '" alt="Uploaded image" />';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($student['first_name']) . ' ' . htmlspecialchars($student['last_name']) . '</h5>';
                                echo '<p class="card-text">รหัสนักศึกษา: ' . htmlspecialchars($student['student_number']) . '</p>';
                                echo '<p class="card-text">คณะ: ' . htmlspecialchars($student['Faculty']) . '</p>';
                                echo '<p class="card-text">สาขาวิชา: ' . htmlspecialchars($student['Field_of_study']) . '</p>';
                                // เพิ่ม input checkbox สำหรับเลือกนักศึกษา
                                echo '<input type="checkbox" name="student_check[]" value="' . $student['id'] . '">';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            echo "</div>";
                            // เพิ่มปุ่มสำหรับส่งฟอร์ม
                            echo "<button type='submit' class='btn btn-primary'>บันทึกข้อมูลที่เลือก</button>";
                            echo "</form>";
                        } else {
                            echo "<p>No students found.</p>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scriptss.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // เมื่อมีการเปลี่ยนแปลงในการเลือกติ๊กบน input checkbox
            $('input[name="student_check[]"]').change(function() {
                // หาตัวแทนของนักศึกษาที่ถูกเลือก
                var selectedStudents = $('input[name="student_check[]"]:checked');
                // สร้างตารางเพื่อแสดงข้อมูลของนักศึกษาที่เลือก
                var selectedData = '<table class="table table-bordered"><thead><tr><th>Student Name</th><th>Student Number</th><th>Faculty</th><th>Field of Study</th><th>Image</th></tr></thead><tbody>';
                // วนลูปผ่านนักศึกษาที่ถูกเลือกและสร้างแถวในตาราง
                selectedStudents.each(function() {
                    // ดึงข้อมูลของนักศึกษาที่เกี่ยวข้อง
                    var cardBody = $(this).closest('.card-body');
                    var studentName = cardBody.find('.card-title').text().trim();
                    var studentNumber = cardBody.find('p:eq(0)').text().split(':')[1].trim();
                    var faculty = cardBody.find('p:eq(1)').text().split(':')[1].trim();
                    var fieldOfStudy = cardBody.find('p:eq(2)').text().split(':')[1].trim();
                    var studentImage = $(this).closest('.card').find('.card-img-top').attr('src'); // URL ของรูปภาพ
                    // เพิ่มแถวในตารางด้วยข้อมูลของนักศึกษาที่เลือก
                    selectedData += '<tr>';
                    selectedData += '<td>' + studentName + '</td>';
                    selectedData += '<td>' + studentNumber + '</td>';
                    selectedData += '<td>' + faculty + '</td>';
                    selectedData += '<td>' + fieldOfStudy + '</td>';
                    selectedData += '<td><img src="' + studentImage + '" alt="Student Image" style="max-width: 100px;"></td>'; // เพิ่มรูปภาพลงในตาราง
                    selectedData += '</tr>';
                });
                selectedData += '</tbody></table>'; // ปิด tag ของตาราง
                $('#selected-students').html(selectedData); // แสดงข้อมูลในตารางที่มี ID selected-students
            });

            $('#select-all').click(function() {
                $('input[name="student_check[]"]').prop('checked', true).trigger('change');
            });

            $('#deselect-all').click(function() {
                $('input[name="student_check[]"]').prop('checked', false).trigger('change');
            });

            $('#student-form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var serializedData = form.serialize() + '&course_id=<?php echo $id; ?>';
    console.log('Serialized Data:', serializedData); // พิมพ์ค่า serialized data ออกมาเพื่อตรวจสอบ

    $.ajax({
        type: 'POST',
        url: 'process_selected_students.php',
        data: serializedData, // ส่งค่า serialized data ที่ตรวจสอบแล้ว
        success: function(response) {
            console.log('Response from server:', response); // เพิ่มการตรวจสอบการตอบสนองจากเซิร์ฟเวอร์
            alert(response);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error); // เพิ่มการตรวจสอบการตอบสนองข้อผิดพลาด
            alert('Error processing the form');
        }
    });
});
        });
    </script>
</body>
</html>
