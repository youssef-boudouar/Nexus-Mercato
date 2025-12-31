<?php

require_once './config/database.php';

class Transfer 
{
    private $id;
    private $player_id;
    private $departure_team_id;
    private $arrival_team_id;
    private $transfer_status;
    private $amount;
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

    public function getDepartureTeamId()
    {
        return $this->departure_team_id;
    }

    public function getArrivalTeamId()
    {
        return $this->arrival_team_id;
    }

    public function getTransferStatus()
    {
        return $this->transfer_status;
    }

    public function getAmount()
    {
        return $this->amount;
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

    public function setDepartureTeamId($departure_team_id)
    {
        $this->departure_team_id = $departure_team_id;
    }

    public function setArrivalTeamId($arrival_team_id)
    {
        $this->arrival_team_id = $arrival_team_id;
    }

    public function setTransferStatus($transfer_status)
    {
        $this->transfer_status = $transfer_status;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
}