<?php

class Specialization
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllSpecialization()
    {
        $stmt = $this->db->query("SELECT * FROM specializations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM specializations WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function addNewSpecialization($name, $icon)
    {
        $stmt = $this->db->prepare("INSERT INTO specializations (name, icon) VALUES (?, ?)");
        $stmt->execute([$name, $icon]);
    }

    public function updateSpecialization($id, $name, $icon)
    {
        $stmt = $this->db->prepare("UPDATE specializations SET name = ?, icon = ? WHERE id = ?");
        $stmt->execute([$name, $icon, $id]);
    }
}
