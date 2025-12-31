<?php

class Team
{
    private $id;
    private $name;
    private $budget;
    private $manager;
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
    public function getName()
    {
        return $this->name;
    }
    public function getBudget()
    {
        return $this->budget;
    }
    public function getManager()
    {
        return $this->manager;
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
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

}