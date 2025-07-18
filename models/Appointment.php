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

    public function countAll()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM appointments");
        return $stmt->fetchColumn();
    }

    public function getPaginated($limit, $offset)
    {
        $stmt = $this->db->prepare("
            SELECT appointments.*, doctors.name AS doctor_name
            FROM appointments
            JOIN doctors ON appointments.doctor_id = doctors.id
            ORDER BY appointment_date DESC, time_slot ASC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($appointmentId, $status)
    {
        $stmt = $this->db->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $appointmentId]);
    }

    public function deleteById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM appointments WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function countPatient()
    {
        $stmt = $this->db->query("SELECT COUNT(DISTINCT patient_name) FROM appointments;");
        return $stmt->fetchColumn();
    }

    public function showRecentBookedAppointment()
    {
        $stmt = $this->db->prepare("
        SELECT ap.patient_name, ap.status, dr.name AS doctor_name 
        FROM appointments AS ap 
        INNER JOIN doctors AS dr ON dr.id = ap.doctor_id 
        ORDER BY ap.created_at DESC 
        LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWeeklyAppointments($from, $to)
    {
        $stmt = $this->db->prepare("
        SELECT DATE(created_at) AS day, COUNT(*) AS total
        FROM appointments
        WHERE DATE(created_at) BETWEEN :from AND :to
        GROUP BY day
        ORDER BY day
    ");
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyAppointments($from, $to)
    {
        $stmt = $this->db->prepare("
        SELECT DATE(created_at) AS day, COUNT(*) AS total
        FROM appointments
        WHERE DATE(created_at) BETWEEN :from AND :to
        GROUP BY day
        ORDER BY day
    ");
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getYearlyAppointments($from, $to)
    {
        $stmt = $this->db->prepare("
        SELECT MONTH(created_at) AS month, COUNT(*) AS total
        FROM appointments
        WHERE DATE(created_at) BETWEEN :from AND :to
        GROUP BY month
        ORDER BY month
    ");
        $stmt->execute(['from' => $from, 'to' => $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
