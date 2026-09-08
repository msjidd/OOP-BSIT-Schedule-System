<?php
require_once __DIR__ . '/Schedule.php';

// Child Class: ClassSchedule
//Represents a regular lecture class schedule for the 1st semester.
//Inherits from Schedule and adds room + credit units.
//Demonstrates method overriding and polymorphism.

class ClassSchedule extends Schedule
{
    // Protected: accessible to this class and its subclasses only
    protected $room;
    protected $units;

    /** @var int Units dedicated to lecture only */
    private $lectureHours;

    public function __construct($subjectCode, $subjectName, $dayOfWeek, $startTime, $endTime, $instructor, $room, $units, $lectureHours)
    {
        // Reuse parent constructor
        parent::__construct($subjectCode, $subjectName, $dayOfWeek, $startTime, $endTime, $instructor);

        $this->room = $room;
        $this->units = $units;
        $this->lectureHours = $lectureHours;
        $this->type = 'Class';
    }

    public function getRoom()         { return $this->room; }
    public function getUnits()        { return $this->units; }
    public function getLectureHours() { return $this->lectureHours; }

    //OVERRIDE #1: getCategory()
    public function getCategory()
    {
        return 'Regular Lecture Class';
    }

    // OVERRIDE #2: getDuration() - lecture-only minutes
    public function getDuration()
    {
        return $this->lectureHours * 60;
    }

    //OVERRIDE #3: displaySummary() - polymorphic output
    public function displaySummary()
    {
        return "{$this->getSubjectCode()} - {$this->getSubjectName()} | {$this->getDayOfWeek()} {$this->getStartTime()}-{$this->getEndTime()} | Room: {$this->room}";
    }
}
