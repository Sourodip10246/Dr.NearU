<?php

require_once __DIR__ . "/../models/Specialization.php";

class SpecializationController{
    private $specializationModel;

    public function __construct($pdo){
        $this->specializationModel = new Specialization($pdo);
    }

    public function index() {
        $specializations = $this->specializationModel->getAllSpecialization();
        return $specializations;
    }
}