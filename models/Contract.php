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

    public function getAll()
    {
        $sql = "SELECT contracts.id, players.name as player, teams.name as team, coaches.name as coach, contracts.salary, contracts.start_date, contracts.end_date 
            FROM contracts 
            LEFT JOIN players ON players.id = contracts.player_id
            LEFT JOIN coaches ON coaches.id = contracts.coach_id
            JOIN teams ON teams.id = contracts.team_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $sql = "INSERT INTO contracts(player_id, coach_id, team_id, salary, start_date, end_date)
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->player_id ,$this->coach_id ,$this->team_id,$this->salary ,$this->start_date ,$this->end_date]);
    }

    public function update()
    {
        $sql = "UPDATE contracts 
        SET player_id = ?, coach_id = ?, team_id = ?, salary = ?, start_date = ?, end_date = ?
        WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->player_id ,$this->coach_id ,$this->team_id,$this->salary ,$this->start_date ,$this->end_date, $this->id]);
    }

    public function delete()
    {
        $sql = "DELETE FROM contracts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM contracts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByPlayer($player_id)
    {
        $sql = "SELECT * FROM contracts WHERE player_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$player_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByCoach($coach_id)
    {
        $sql = "SELECT * FROM contracts WHERE coach_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$coach_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByTeam($team_id)
    {
        $sql = "SELECT * FROM contracts WHERE team_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$team_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}