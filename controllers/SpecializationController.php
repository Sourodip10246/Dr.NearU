<?php

require_once __DIR__ . "/../models/Specialization.php";

class SpecializationController
{
    private $specializationModel;

    public function __construct($pdo)
    {
        $this->specializationModel = new Specialization($pdo);
    }

    public function index()
    {
        $specializations = $this->specializationModel->getAllSpecialization();
        return $specializations;
    }

    public function deleteById($id)
    {
        return $this->specializationModel->deleteById($id);
    }

    public function addNewSpe($name, $icon)
    {
        if (!empty($name) and !empty($icon)) {
            return $this->specializationModel->addNewSpecialization($name, $icon);
        }
    }

    public function updateSpe($id, $name, $icon)
    {
        if (!empty($name) and  !empty($icon)) {
            return $this->specializationModel->updateSpecialization($id, $name, $icon);
        }
    }

    public function countSpe(){
        return $this->specializationModel->getSpeCount();
    }
}
