<div class="overlay" id="overlay"></div> <!-- เพิ่ม overlay -->

<!-- Sidebar -->
    <div class="border-end bg-white" id="sidebar-wrapper">
        <div class="sidebar-heading">
            <?php if ($isLoggedIn && !empty($userImage)): ?>
                <img src="<?php echo $userImage; ?>" alt="User Profile" class="profile-img">
            <?php endif;?>
            <div class="profile-info">
                <strong><?php echo $isLoggedIn ? $userName : 'Project'; ?></strong>
                <?php if ($isLoggedIn): ?>
                    <small><?php echo $userEmail; ?></small>
                <?php endif;?>
            </div>
        </div>
        <br>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action list-group-item-light mb-2" href="addtable.php" style="font-size: 1rem; ">
                <i class="fas fa-home fa-lg" style="font-size: 1.5rem; margin-left: 10px;" ></i> HOME
            </a>
            <a class="list-group-item list-group-item-action list-group-item-light mb-2" href="http://localhost/myproject/calendar.php" style="font-size: 1rem;">
                <i class="fas fa-calendar fa-lg" style="font-size: 1.5rem; margin-left: 10px;"></i> CALENDAR
            </a>
        </div>
        <br>
        <hr>
        <div class="responsive-div" style="margin-left: 30px;">ENROLLED</div>
            <div class="btn-container-2">
                <?php
                // Courses list in Menu
                foreach ($courses as $course):
                    $color = getColorForCourse($course['subject_id']);
                    $subjectName = htmlspecialchars($course['subject_name']);
                    $day_of_week = htmlspecialchars($course['day_of_week']);
                    // ตัดข้อมูลให้แสดงแค่ 3 ตัวอักษรแรก
                    $shortName = mb_substr($day_of_week, 0, 3);
                ?>
	            <!-- Link to Section of left menu -->
			    <a href="../web_app/section/import-students/manage-members.php?subject_id=<?php echo htmlspecialchars($course['subject_id']); ?>" class="btn btn-circle">
			        <div class="circle-icon" style="background-color: <?php echo $color; ?>; margin-left: 9px;">
			            <span class="circle-text"><?php echo $shortName; ?></span>
				    </div>

			        <div class="course-info">
				        <div class="info-row">
				            <span class="subject-namee"><?php echo $subjectName; ?></span>
				        </div>
				        <div class="info-row">
				            <span class="course-details-2">
				                (<?php echo htmlspecialchars($course['start_time']) . " - " . htmlspecialchars($course['end_time']); ?>) <?php echo htmlspecialchars($course['day_of_week']); ?>
				                    Sec: <?php echo htmlspecialchars($course['section']); ?>
				            </span>
				        </div>
				    </div>
			    </a>
			    <?php endforeach;?>
            </div>
            <hr>
            <div class="list-group list-group-flush">
                <!-- Other links -->
                <a href="<?php echo $logoutUrl; ?>" id="logout-button" class="list-group-item list-group-item-action list-group-item-light mb-2" style="font-size: 1rem;">
                    <i class="fas fa-sign-out-alt" style="font-size: 1.5rem; margin-left: 5px;"></i>LOG OUT
                </a>
            </div>
    </div>
