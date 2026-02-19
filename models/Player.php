<?php
declare(strict_types=1);

require_once 'Person.php';
require_once __DIR__ . '/../config/database.php';

/**
 * Player Entity
 * 
 * Represents a football player in the system.
 * Extends Person to inherit common identity traits.
 * Implements Active Record pattern for data persistence.
 */
class Player extends Person
{
    private string $position;
    private float $market_value;
    private ?string $image_url = null;

    // Getters

    public function getPosition(): string
    {
        return $this->position;
    }
    
    public function getMarketValue(): float
    {
        return $this->market_value;
    }
    
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    // Setters

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }
    
    public function setMarketValue(float $market_value): void
    {
        $this->market_value = $market_value;
    }
    
    public function setImageUrl(?string $image_url): void
    {
        $this->image_url = $image_url;
    }

    /**
     * Retrieve all players from the database.
     * 
     * @return array<array> List of players
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM players ORDER BY market_value DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Persist new player to database.
     * 
     * @return bool True on success
     */
    public function create(): bool
    {
        $sql = "INSERT INTO players(name, nationality, position, market_value, image_url) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $this->name, 
            $this->nationality, 
            $this->position, 
            $this->market_value, 
            $this->image_url ?? 'assets/img/default_pro.png' // Default asset if null
        ]);
    }

    public function update(): bool
    {
        $sql = "UPDATE players SET name = ?, nationality = ?, position = ?, market_value = ?, image_url = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $this->name, 
            $this->nationality, 
            $this->position, 
            $this->market_value, 
            $this->image_url, 
            $this->id
        ]);
    }

    /**
     * @return array|false
     */
    public function findById(int $id): array|false
    {
        $sql = "SELECT * FROM players WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM players WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    /**
     * Polymorphic implementation of cost calculation.
     */
    public function getAnnualCost(): float
    {
        // Business Logic: Salary is 20% of market value
        return $this->market_value * 0.2;
    }
}