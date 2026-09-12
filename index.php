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

<!-- ==============================
     WELCOME SECTION
     ============================== -->

<div class="hero">
    <h1>Welcome</h1>

    <p>
        Your academic schedule, organized in one place.
        Easily manage class, laboratory, and examination schedules
        for a more organized and productive semester.
    </p>
</div>


<!-- ==============================
     SYSTEM OVERVIEW
     ============================== -->

<div class="card">
    <h2>System Overview</h2>

    <p class="lead">
        The Academic Schedule Management System (ASMS) is a web-based
        system designed to organize and manage academic schedules.
        It allows users to create, view, and manage class, laboratory,
        and examination schedules efficiently, making schedule planning
        simple, clear, and convenient.
    </p>
</div>


<!-- ==============================
     QUICK ACTION BUTTONS
     ============================== -->

<div class="btn-container">

    <a href="view_schedule.php" class="btntop">
        View All Schedules
    </a>

    <a href="create_schedule.php" class="btntop secondary">
        Create a Schedule
    </a>

</div>


<!-- ==============================
     SCHEDULE FEATURES
     ============================== -->

<div class="grid">

    <!-- CLASS SCHEDULE -->

    <div class="feature">

        <div class="icon">
            &#127891;
        </div>

        <h3>Class Schedule</h3>

        <p>
            Manage regular lecture sessions with course,
            instructor, room, schedule, and credit unit details.
        </p>

        <a href="create_schedule.php" class="btn btn-block">
            Create Class
        </a>

    </div>


    <!-- EXAM SCHEDULE -->

    <div class="feature">

        <div class="icon">
            &#128221;
        </div>

        <h3>Exam Schedule</h3>

        <p>
            Organize periodical examinations by exam type,
            subject, schedule, room, and grading period.
        </p>

        <a href="create_schedule.php" class="btn btn-block">
            Create Exam
        </a>

    </div>


    <!-- LABORATORY SCHEDULE -->

    <div class="feature">

        <div class="icon">
            &#128300;
        </div>

        <h3>Laboratory Schedule</h3>

        <p>
            Manage hands-on laboratory sessions with laboratory
            rooms, equipment, schedules, and other details.
        </p>

        <a href="create_schedule.php" class="btn btn-block">
            Create Laboratory
        </a>

    </div>

</div>


<?php include __DIR__ . '/includes/footer.php'; ?>