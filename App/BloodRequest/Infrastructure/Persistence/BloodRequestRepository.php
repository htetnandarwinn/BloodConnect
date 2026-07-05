<?php

namespace App\BloodRequest\Infrastructure\Persistence;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Shared\Infrastructure\Database\Database;
use PDO;

class BloodRequestRepository implements BloodRequestRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findById(int $id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM blood_requests WHERE request_id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function findByPatientId(int $patientId)
    {
        $stmt = $this->db->prepare("
   SELECT
    br.request_id,
    br.request_code,
    br.patient_id,
    br.patient_name,
    br.blood_group_needed,
    br.unit,
    br.hospital_name,
    br.urgency,
    br.contact_phone,
    br.created_at,
    md.label AS status
FROM blood_requests br
INNER JOIN master_data md
    ON br.status = md.id
WHERE br.patient_id = ?
ORDER BY br.created_at DESC
");

        $stmt->execute([$patientId]);

        return $stmt->fetchAll();
    }
    public function create(array $data)
    {
        $sql = "
INSERT INTO blood_requests (
    request_code,
    patient_id,
    patient_name,
    blood_group_needed,
    unit,
    hospital_name,
    urgency,
    contact_phone,
    status
)
VALUES (
    :request_code,
    :patient_id,
    :patient_name,
    :blood_group_needed,
    :unit,
    :hospital_name,
    :urgency,
    :contact_phone,
    :status
)
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':request_code'       => $data['request_code'],
            ':patient_id'         => $data['patient_id'],
            ':patient_name'       => $data['patient_name'],
            ':blood_group_needed' => $data['blood_group_needed'],
            ':unit'               => $data['unit'],
            ':hospital_name'      => $data['hospital_name'],
            ':urgency'            => $data['urgency'],
            ':contact_phone'      => $data['contact_phone'],
            ':status'             => $data['status'],
        ]);
    }

    public function getPatientStats(int $patientId)
    {
        $stmt = $this->db->prepare("
        SELECT 
            COUNT(*) AS total_requests,

            SUM(CASE WHEN br.status = 28 THEN 1 ELSE 0 END) AS pending_requests,
            SUM(CASE WHEN br.status = 29 THEN 1 ELSE 0 END) AS accepted_requests,
            SUM(CASE WHEN br.status = 30 THEN 1 ELSE 0 END) AS completed_requests

        FROM blood_requests br
        WHERE br.patient_id = ?
    ");

        $stmt->execute([$patientId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
