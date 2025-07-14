<?php

require_once __DIR__ . "/../models/Appointment.php";

class AppointmentController {
    private $appointModel;

    public function __construct($pdo)
    {
        $this->appointModel = new Appointment($pdo);
    }

    public function add(array $data){
        return $this->appointModel->addNewAppointment($data);
    }

    public function isExist(array $data) {
        return $this->appointModel->getAppointmentByDocId($data['doctor_id'], $data['appointment_date'], $data['time_slot']);
    }
}