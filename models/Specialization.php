<?php 

class Specialization{
    private $db;

    public function __construct($pdo){
        $this->db = $pdo;
    }

    public function getAllSpecialization(){
        $stmt = $this->db->query("SELECT * FROM specializations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}