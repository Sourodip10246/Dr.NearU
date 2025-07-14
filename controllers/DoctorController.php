<?php 

require_once __DIR__ . "/../models/Doctor.php";

class DoctorController {
    private $doctorModel;

    public function __construct($pdo) {
        $this->doctorModel = new Doctor($pdo);
    }

    public function index() {
        $doctors = $this->doctorModel->getAllDoctors();
        return $doctors;
    }

    public function filterDoc($name, $type){
        if (isset($name) and !empty($name)){
            $doctors = $this->doctorModel->getDoctorsByName($name);
            return $doctors;
        } elseif(isset($type) and !empty($type)){
            $doctors = $this->doctorModel->getDoctorsBySpecializationId($type);
            return $doctors;
        } else {
            $doctors = $this->doctorModel->getDoctorsByNameAndSpecializationId($name, $type);
            return $doctors;
        }
        
    } 
    
}