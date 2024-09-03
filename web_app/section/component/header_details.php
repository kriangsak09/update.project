<!-- Header Details -->
<div class="mt-3">
    <h1 class="mb-4"><?php echo htmlspecialchars($subject_id); ?> : <?php echo htmlspecialchars($subject_name); ?></h1>
    <p>Semester : <?php echo htmlspecialchars($semester); ?></p>
    <p>Academic Year : <?php echo htmlspecialchars($academic_year); ?></p>
    <p>Section : <?php echo htmlspecialchars($section); ?></p>
    <p>Location : <?php echo htmlspecialchars($classroom_id); ?></p>
    <br>
    <br>
    <p><?php echo htmlspecialchars(urldecode($day_of_week)); ?> (<?php echo htmlspecialchars(urldecode($start_time)); ?> - <?php echo htmlspecialchars(urldecode($end_time)); ?>)</p>
</div>
<!-- End Header Details -->
