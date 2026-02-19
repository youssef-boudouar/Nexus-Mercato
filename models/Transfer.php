<?php

require_once '../config/database.php';

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

    public function getAll()
    {
        $sql = "SELECT players.name AS player, players.image_url AS player_image,
                       players.position, players.nationality,
                       teamA.name AS departure_team, teamA.logo_url AS departure_logo,
                       teamB.name AS arrival_team, teamB.logo_url AS arrival_logo,
                       transfer_status, amount, transfers.id
                FROM transfers
                JOIN players ON transfers.player_id = players.id
                JOIN teams AS teamA ON transfers.departure_team_id = teamA.id
                JOIN teams AS teamB ON transfers.arrival_team_id = teamB.id
                ORDER BY transfers.id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $sql = "INSERT INTO transfers(player_id, departure_team_id, arrival_team_id, transfer_status, amount) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->player_id, $this->departure_team_id, $this->arrival_team_id, $this->transfer_status, $this->amount]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM transfers WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return  $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $sql = "UPDATE transfers 
            SET player_id = ?, 
                departure_team_id = ?, 
                arrival_team_id = ?, 
                transfer_status = ?, 
                amount = ? 
            WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $this->player_id,
            $this->departure_team_id,
            $this->arrival_team_id,
            $this->transfer_status,
            $this->amount,
            $this->id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM transfers WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function getByPlayer($player_id)
    {
        $sql = "SELECT * FROM transfers WHERE player_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$player_id]);
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByArrivalTeam($arrival_team_id)
    {
        $sql = "SELECT * FROM transfers WHERE arrival_team_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$arrival_team_id]);
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByDepartureTeam($departure_team_id)
    {
        $sql = "SELECT * FROM transfers WHERE departure_team_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$departure_team_id]);
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
