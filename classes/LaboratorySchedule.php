<?php
require_once __DIR__ . '/Schedule.php';

// Child Class: LaboratorySchedule
//Represents a hands-on laboratory schedule in the 1st semester.
//Inherits from Schedule and adds lab room + equipment requirements.
 
class LaboratorySchedule extends Schedule
{
    // Protected: shared with subclasses
    protected $labRoom;
    protected $equipment;

    // Private: internal safety compliance flag
    private $safetyChecked;

    public function __construct($subjectCode, $subjectName, $dayOfWeek, $startTime, $endTime, $instructor, $labRoom, $equipment, $safetyChecked)
    {
        parent::__construct($subjectCode, $subjectName, $dayOfWeek, $startTime, $endTime, $instructor);

        $this->labRoom = $labRoom;
        $this->equipment = $equipment;
        $this->safetyChecked = $safetyChecked;
        $this->type = 'Laboratory';
    }

    public function getLabRoom()    { return $this->labRoom; }
    public function getEquipment()  { return $this->equipment; }
    public function isSafetyChecked() { return $this->safetyChecked; }

    //OVERRIDE #1: getCategory()
    public function getCategory()
    {
        return 'Laboratory Session';
    }

    //OVERRIDE #2: getDuration() - lab session, includes pre/post setup
     public function getDuration()
    {
        return parent::getDuration() + 30; // +30 min for setup & cleanup
    }

    //OVERRIDE #3: displaySummary() - polymorphic output
     public function displaySummary()
    {
        return "{$this->getSubjectCode()} - {$this->getSubjectName()} | LAB {$this->getDayOfWeek()} {$this->getStartTime()}-{$this->getEndTime()} | {$this->labRoom}";
    }
}
