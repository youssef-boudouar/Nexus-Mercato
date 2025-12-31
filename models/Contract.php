<?php

class Contract
{
    private $id;
    private $player_id;
    private $coach_id;
    private $team_id;
    private $salary;
    private $start_date;
    private $end_date;
    private $db;

    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Getters

     public function getId()
    {
        return $this->id;
    }

    public function getPlayerId()
    {
        return $this->player_id;
    }

    public function getCoachId()
    {
        return $this->coach_id;
    }

    public function getTeamId()
    {
        return $this->team_id;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPlayerId($player_id)
    {
        $this->player_id = $player_id;
    }

    public function setCoachId($coach_id)
    {
        $this->coach_id = $coach_id;
    }

    public function setTeamId($team_id)
    {
        $this->team_id = $team_id;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

}