<?php
require_once __DIR__ . '/classes/Schedule.php';
require_once __DIR__ . '/classes/ClassSchedule.php';
require_once __DIR__ . '/classes/ExamSchedule.php';
require_once __DIR__ . '/classes/LaboratorySchedule.php';
require_once __DIR__ . '/includes/validator.php';

/**
 * PolyPro on process_schedule.php
 * 
 * 1. Validate input via the Validator class.
 * 2. Instantiate the correct subclass using the schedule type.
 * 3. Store the object in a shared in-memory session registry (no database).
 * 4. Redirect to view_schedule.php to display polymorphic results.
 */

session_start();

// Clear the in-memory registry at the start of a fresh session
if (!isset($_SESSION['schedules'])) {
    $_SESSION['schedules'] = [];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$post = $_POST;

// 1. Validation
$errors = Validator::validateScheduleInput($post);

if (!empty($errors)) {
    $query = http_build_query([
        'errors' => json_encode($errors),
        'data'   => json_encode($post),
    ]);
    header('Location: create_schedule.php?' . $query);
    exit;
}

// 2. Object creation - instantiate the appropriate subclass
$type = $post['schedule_type'];
$schedule = null;

switch ($type) {
    case 'class':
        $schedule = new ClassSchedule(
            $post['subject_code'],
            $post['subject_name'],
            $post['day'],
            $post['start_time'],
            $post['end_time'],
            $post['instructor'],
            $post['room'],
            (int)$post['units'],
            (int)$post['lecture_hours']
        );
        break;

    case 'exam':
        $schedule = new ExamSchedule(
            $post['subject_code'],
            $post['subject_name'],
            $post['day'],
            $post['start_time'],
            $post['end_time'],
            $post['instructor'],
            $post['exam_type'],
            $post['grading_period'],
            isset($post['has_time_limit'])
        );
        break;

    case 'laboratory':
        $schedule = new LaboratorySchedule(
            $post['subject_code'],
            $post['subject_name'],
            $post['day'],
            $post['start_time'],
            $post['end_time'],
            $post['instructor'],
            $post['lab_room'],
            $post['equipment'],
            isset($post['safety_checked'])
        );
        break;

    default:
        $errors[] = 'Invalid schedule type selected.';
        break;
}

if ($schedule === null) {
    $query = http_build_query([
        'errors' => json_encode($errors),
        'data'   => json_encode($post),
    ]);
    header('Location: create_schedule.php?' . $query);
    exit;
}

// 3. Store in in-memory session (no database)
$_SESSION['schedules'][] = $schedule;

// Remember the last created object for a focused result view
$_SESSION['last_schedule'] = count($_SESSION['schedules']) - 1;

// Redirect with a success message
header('Location: view_schedule.php?created=1');
exit;
