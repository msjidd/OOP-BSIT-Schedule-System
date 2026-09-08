<?php
//Validator - input validation helpers for schedule processing.
//Prevents incomplete or invalid input.

class Validator
{
    //Collect validation errors from the POST schedule form.
    public static function validateScheduleInput(array $post)
    {
        $errors = [];

        $required = [
            'subject_code'  => 'Subject Code',
            'subject_name'  => 'Subject Name',
            'day'           => 'Day of Week',
            'start_time'    => 'Start Time',
            'end_time'      => 'End Time',
            'instructor'    => 'Instructor',
            'schedule_type' => 'Schedule Type',
        ];

        foreach ($required as $key => $label) {
            if (!isset($post[$key]) || trim($post[$key]) === '') {
                $errors[] = "The {$label} field is required.";
            }
        }

        if (!empty($post['start_time']) && !empty($post['end_time'])) {
            $s = new DateTime($post['start_time']);
            $e = new DateTime($post['end_time']);
            if ($e <= $s) {
                $errors[] = 'End time must be later than the start time.';
            }
        }

        // Type-specific validations
        $type = isset($post['schedule_type']) ? $post['schedule_type'] : '';

        if ($type === 'class') {
            if (empty(trim($post['room'] ?? ''))) {
                $errors[] = 'Room is required for a class schedule.';
            }
            if (!isset($post['units']) || trim($post['units']) === '' || (int)$post['units'] < 1) {
                $errors[] = 'Credit units must be at least 1.';
            }
            if (!isset($post['lecture_hours']) || trim($post['lecture_hours']) === '' || (int)$post['lecture_hours'] < 1) {
                $errors[] = 'Lecture hours must be at least 1.';
            }
        }

        if ($type === 'exam') {
            if (empty(trim($post['exam_type'] ?? ''))) {
                $errors[] = 'Exam type is required for an exam schedule.';
            }
            if (empty(trim($post['grading_period'] ?? ''))) {
                $errors[] = 'Grading period is required for an exam schedule.';
            }
        }

        if ($type === 'laboratory') {
            if (empty(trim($post['lab_room'] ?? ''))) {
                $errors[] = 'Lab room is required for a laboratory schedule.';
            }
            if (empty(trim($post['equipment'] ?? ''))) {
                $errors[] = 'Equipment requirement is required for a laboratory schedule.';
            }
        }

        return $errors;
    }
}
