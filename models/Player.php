<?php


class Player extends Person
{
    private $position;
    private $market_value;

    // Getters

    public function getPosition()
    {
        return $this->position;
    }
    public function getMarketValue()
    {
        return $this->market_value;
    }

    // Setter

    public function setPosition($position)
    {
        $this->position = $position;
    }
    public function setMarketValue($market_value)
    {
        $this->market_value = $market_value;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM players";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $sql = "INSERT INTO players(name, nationality, position, market_value) VALUES(?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->nationality, $this->position, $this->market_value]);
    }

    public function update()
    {
        $sql = "UPDATE players SET name = ?, nationality = ?, position = ?, market_value = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->nationality, $this->position, $this->market_value, $this->id]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM players WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete()
    {
        $sql = "DELETE FROM players WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    public function getAnnualCost()
    {
        return $this->market_value * 0.2;
    }
}
