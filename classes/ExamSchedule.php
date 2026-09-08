<?php
require_once __DIR__ . '/Schedule.php';

//Child Class: ExamSchedule
// Represents a periodical exam schedule in the 1st semester.
//Inherits from Schedule and adds exam type + grading period.

class ExamSchedule extends Schedule
{
    // Protected: shared with any future subclasses
    protected $examType;
    protected $gradingPeriod;

    // Private: internal exam format flag
    private $hasTimeLimit;

    public function __construct($subjectCode, $subjectName, $dayOfWeek, $startTime, $endTime, $instructor, $examType, $gradingPeriod, $hasTimeLimit)
    {
        parent::__construct($subjectCode, $subjectName, $dayOfWeek, $startTime, $endTime, $instructor);

        $this->examType = $examType;
        $this->gradingPeriod = $gradingPeriod;
        $this->hasTimeLimit = $hasTimeLimit;
        $this->type = 'Exam';
    }

    public function getExamType()      { return $this->examType; }
    public function getGradingPeriod() { return $this->gradingPeriod; }
    public function hasTimeLimit()     { return $this->hasTimeLimit; }

    //OVERRIDE #1: getCategory()
    public function getCategory()
    {
        return 'Examination';
    }

    //OVERRIDE #2: getDuration() - exam time; capped at 90 min when a time limit is set
     public function getDuration()
    {
        $minutes = parent::getDuration();
        if ($this->hasTimeLimit && $minutes > 90) {
            return 90;
        }
        return $minutes;
    }

    //OVERRIDE #3: displaySummary() - polymorphic output
     public function displaySummary()
    {
        return "{$this->getSubjectCode()} | {$this->examType} ({$this->gradingPeriod}) | {$this->getDayOfWeek()} {$this->getStartTime()}-{$this->getEndTime()}";
    }
}
