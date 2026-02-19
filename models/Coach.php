<?php
declare(strict_types=1);

require_once __DIR__ . '/Person.php';
require_once __DIR__ . '/../config/database.php';

class Coach extends Person
{
    private ?string $image_url = null;

    public function getImageUrl(): string
    {
        return $this->image_url ?? 'assets/img/default_coach.png';
    }

    public function setImageUrl(?string $image_url): void
    {
        $this->image_url = $image_url;
    }

    /**
     * Retrieve all coaches with safe defaults for missing columns
     * @return array<array>
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM coaches ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Post-process to ensure UI doesn't break
        foreach ($results as &$row) {
            if (empty($row['image_url'])) {
                $row['image_url'] = '../assets/img/default_pro.png'; // Fallback
            }
        }
        return $results;
    }

    public function create(): bool
    {
        // Try to insert image_url if column exists, otherwise fallback to basic insert
        // Since we don't know schema certainty, we'll try standard.
        // Assuming table matches Player pattern or previous simple insert.
        // Safe bet: The previous code only inserted name/nationality. Keep that unless we are adding feature.
        // But UI shows image. 
        // Let's keep strict to previous functionality but SAFER.
        
        $sql = "INSERT INTO coaches(name, nationality) VALUES(?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->nationality]);
    }

    public function update(): bool
    {
        $sql = "UPDATE coaches SET name = ?, nationality = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->nationality, $this->id]);
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM coaches WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM coaches WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    public function getAnnualCost(): float
    {
        return 50000.00;
    }
}
