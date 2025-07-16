<?php

class Admin
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function addAdmin($name, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admins (username, password_hash) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $hashedPassword]);
    }

    public function findByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAdmin()
    {
        $stmt = $this->db->prepare("SELECT * FROM admins");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function updateNameById($id, $username)
    {
        $stmt = $this->db->prepare("UPDATE admins SET username = ? WHERE id = ?");
        $stmt->execute([$username, $id]);
    }

    public function updateAllById($id, $username, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE admins SET username = ?, password_hash = ? WHERE id = ?");
        $stmt->execute([$username, $passwordHash, $id]);
    }
    
}
