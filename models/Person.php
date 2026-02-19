<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

/**
 * Abstract Person Class
 * 
 * Base entity for all human resources (Players, Coaches) in the system.
 * Enforces a consistent contract for common attributes.
 */
abstract class Person
{
    protected int $id;
    protected string $name;
    protected string $nationality;
    protected ?PDO $db;

    public function __construct()
    {
        // Dependency Injection via Singleton (Service Locator pattern)
        // ideally this should be injected into constructor, but we are refactoring legacy code
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNationality(): string
    {
        return $this->nationality;
    }

    // Setters

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setNationality(string $nationality): void
    {
        $this->nationality = $nationality;
    }

    /**
     * Polymorphic method to be implemented by child execution classes.
     */
    abstract public function getAnnualCost(): float;
}
