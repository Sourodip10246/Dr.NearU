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

        $sql = "INSERT INTO admins (name, password) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $hashedPassword]);
    }

    public function findByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
