<?php
// Load classes used across all pages
require_once __DIR__ . '/classes/Schedule.php';
require_once __DIR__ . '/classes/ClassSchedule.php';
require_once __DIR__ . '/classes/ExamSchedule.php';
require_once __DIR__ . '/classes/LaboratorySchedule.php';

$pageTitle = 'Dashboard';
$activePage = 'home';
include __DIR__ . '/includes/header.php';
?>

<div class="hero">
    <h1><b>Welcome</h1>
    <p>Manage your academic schedules in one place. Create, update, and organize class, laboratory, and examination schedules quickly and efficiently for the 1st Semester.
    </p>
</div>

<div class="card">
    <h2>System Overview</h2>
    <p class="lead">
    The BSIT Class Schedule System is designed to help organize academic schedules for the semester. Users can create and manage class, laboratory, and examination schedules through an easy-to-use interface, making schedule planning faster, clearer, and more organized.
    </p>
</div>

<div class="grid">
    <div class="feature">
        <div class="icon">&#127891;</div>
        <h3>Class Schedule</h3>
        <p>Regular lecture sessions with assigned rooms and credit units.</p>
        <a href="create_schedule.php" class="btn btn-block">Create Class</a>
    </div>
    <div class="feature">
        <div class="icon">&#128221;</div>
        <h3>Exam Schedule</h3>
        <p>Periodical examinations with exam type and grading period.</p>
        <a href="create_schedule.php" class="btn btn-block">Create Exam</a>
    </div>
    <div class="feature">
        <div class="icon">&#128300;</div>
        <h3>Laboratory Schedule</h3>
        <p>Hands-on lab sessions with equipment and lab room details.</p>
        <a href="create_schedule.php" class="btn btn-block">Create Lab</a>
    </div>
</div>

<div class="btn-container">
    <a href="#" class="btntop">View All Schedules</a>
    <a href="#" class="btntop secondary">Create a Schedule</a>
</div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
