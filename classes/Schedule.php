<?php
//Parent Class: Schedule
//Represents a generic schedule entry for the BSIT 1st Semester.
//Contains common properties and methods shared by all schedule types.
//Encapsulation: uses private, protected, and public access modifiers.
//Polymorphism base: default displaySummary() and getDuration() methods are overridden by child classes.

class Schedule
{
    // Encapsulation - private properties only accessible via getters/setters
    private $subjectCode;
    private $subjectName;
    private $dayOfWeek;
    private $startTime;
    private $endTime;
    private $instructor;

    /** @var string Track which subclass created this instance */
    protected $type;

    /** @var array Static storage of all schedule objects (in-memory, no DB) */
    private static $registry = [];

    //Constructor - initializes common schedule properties.
    public function __construct($subjectCode, $subjectName, $dayOfWeek, $startTime, $endTime, $instructor)
    {
        $this->subjectCode = $subjectCode;
        $this->subjectName = $subjectName;
        $this->dayOfWeek = $dayOfWeek;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->instructor = $instructor;
        $this->type = 'Generic';
    }

    // ===== Getters (encapsulation) =====
    public function getSubjectCode() { return $this->subjectCode; }
    public function getSubjectName() { return $this->subjectName; }
    public function getDayOfWeek()   { return $this->dayOfWeek; }
    public function getStartTime()   { return $this->startTime; }
    public function getEndTime()     { return $this->endTime; }
    public function getInstructor()  { return $this->instructor; }
    public function getType()        { return $this->type; }

    //Polymorphism base: override in children.
    // Returns a short label describing the schedule category.

    public function getCategory()
    {
        return 'General Schedule';
    }

    //Compute duration in minutes (shared helper for all subclasses).
    protected function computeDurationMinutes()
    {
        $start = new DateTime($this->startTime);
        $end = new DateTime($this->endTime);
        $diff = $end->diff($start);
        return ($diff->h * 60) + $diff->i;
    }

    // Polymorphism base: override in children.
    //Returns the number of duration minutes.
    public function getDuration()
    {
        return $this->computeDurationMinutes();
    }

    //Polymorphism base: override in children.
    //Return a human-readable summary of the schedule.
    public function displaySummary()
    {
        return "{$this->subjectCode} - {$this->subjectName} ({$this->dayOfWeek}, {$this->startTime}-{$this->endTime})";
    }

    // ===== Static registry (in-memory storage, no database) =====
    public static function add(Schedule $obj)
    {
        self::$registry[] = $obj;
    }

    public static function all()
    {
        return self::$registry;
    }

    public static function clear()
    {
        self::$registry = [];
    }
}
