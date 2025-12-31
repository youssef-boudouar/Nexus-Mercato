<?php

class Coach extends Person 
{

    public function getAll()
    {
        $sql = "SELECT * FROM coaches";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $sql = "INSERT INTO coaches(name, nationality) VALUES(?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->nationality]);
    }

    public function update()
    {
        $sql = "UPDATE coaches SET name = ?, nationality = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->nationality, $this->id]);
    }
    
    public function findById($id)
    {
        $sql = "SELECT * FROM coaches WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete()
    {
        $sql = "DELETE FROM coaches WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->id]);
    }

}