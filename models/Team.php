<?php

require_once '../config/database.php';


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

    // CRUD




    public function create()
    {
        $sql = "INSERT INTO teams(name, budget, manager) VALUES(?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->budget, $this->manager]);
    }

    public function update()
    {
        $sql = "UPDATE teams SET name = ?, budget = ?, manager = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->budget, $this->manager, $this->id]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM teams WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete()
    {
        $sql = "DELETE FROM teams WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->id]);
    }
    public function getTotalTeams()
    {
        $sql = "SELECT count(id) as total FROM teams";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getAll()
    {
        $sql = "SELECT * FROM teams ORDER BY budget DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllPagination($start, $resultPerPage)
    {
        $sql = "SELECT * FROM teams ORDER BY budget DESC LIMIT $start, $resultPerPage";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
