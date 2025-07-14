<?php

class Appointment
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAppointmentByDocId($id, $date, $time)
    {
        $stmt = $this->db->prepare("SELECT * FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND time_slot = ? AND status = 'confirmed'");
        $stmt->execute([$id, $date, $time]);
        return $stmt->fetch() ? true : false;
    }


    public function addNewAppointment(array $data): bool
    {
        $sql = "INSERT INTO appointments
                   (patient_name, email, phone, doctor_id,
                    appointment_date, time_slot, reason, status)
                VALUES
                   (:patient_name, :email, :phone, :doctor_id,
                    :appointment_date, :time_slot, :reason, :status)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':patient_name'     => $data['patient_name'],
            ':email'            => $data['email']            ?? null,
            ':phone'            => $data['phone']            ?? null,
            ':doctor_id'        => (int) $data['doctor_id'],
            ':appointment_date' => $data['appointment_date'],
            ':time_slot'        => $data['time_slot'],
            ':reason'           => $data['reason']           ?? null,
            ':status'           => $data['status']           ?? 'pending',
        ]);
    }
}
