<?php

abstract class Person
{
    protected int $id;
    protected string $name;
    protected string $nationality;
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getNationality()
    {
        return $this->nationality;
    }

    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    abstract public function getAnnualCost();
}
