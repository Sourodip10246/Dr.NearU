<?php

class Doctor
{
    private $db;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllDoctors()
    {
        $stmt = $this->db->query("SELECT dr.id, dr.specialization_id, dr.name, dr.image, dr.available_days, dr.start_time, dr.end_time, dr.slot_duration, sp.name AS sp_name FROM doctors AS dr INNER JOIN specializations AS sp ON dr.specialization_id = sp.id;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------- 1. Search by doctor name ---------- */
    public function getDoctorsByName(string $name): array
    {
        $sql = "
            SELECT  dr.id,
                    dr.specialization_id,
                    dr.name,
                    dr.image,
                    sp.name                AS sp_name
            FROM    doctors dr
            INNER   JOIN specializations sp ON dr.specialization_id = sp.id
            WHERE   dr.name LIKE :name
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':name' => "%{$name}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------- 2. Search by specialization ID ---------- */
    public function getDoctorsBySpecializationId(int $specId): array
    {
        $sql = "
            SELECT  dr.id,
                    dr.specialization_id,
                    dr.name,
                    dr.image,
                    sp.name                     AS sp_name
            FROM    doctors dr
            INNER   JOIN specializations sp ON dr.specialization_id = sp.id
            WHERE   dr.specialization_id = :spec
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':spec' => $specId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------- 3. Search by BOTH name and specialization ID ---------- */
    public function getDoctorsByNameAndSpecializationId(
        string $name,
        int $specId
    ): array {
        $sql = "
        SELECT  dr.id,
                dr.specialization_id  AS sp_id,
                dr.name,
                dr.image,
                sp.name               AS sp_name
        FROM    doctors dr
        INNER   JOIN specializations sp ON dr.specialization_id = sp.id
        WHERE   dr.name LIKE :name
          AND   dr.specialization_id = :spec
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => "%{$name}%",   // <— wildcards wrapped correctly
            ':spec' => $specId        // <— integer ID
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
