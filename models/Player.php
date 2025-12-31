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
}