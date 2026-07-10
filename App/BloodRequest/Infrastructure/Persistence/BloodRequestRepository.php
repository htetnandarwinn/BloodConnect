<?php

namespace App\BloodRequest\Infrastructure\Persistence;

use App\BloodRequest\Domain\Repository\BloodRequestRepositoryInterface;
use App\Shared\Infrastructure\Database\Database;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;
use PDO;

class BloodRequestRepository implements BloodRequestRepositoryInterface
{
    private PDO $db;


    public function __construct()
    {
        $this->db = Database::getConnection();
    }


    // ================= FIND REQUESTS BY PATIENT =================

    public function findByPatientId(int $patientId): array
    {
        $sql = "
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

        LEFT JOIN master_data md
            ON br.status = md.id

        WHERE br.patient_id = ?

        ORDER BY br.created_at DESC
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $patientId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= FIND BY ID =================

    public function findById(int $id)
    {
        $stmt = $this->db->prepare(
            "
            SELECT *
            FROM blood_requests
            WHERE request_id = ?
            "
        );


        $stmt->execute([$id]);


        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findPatientRequestDetail(int $requestId, int $patientId): array
    {
        $stmt = $this->db->prepare(
            "
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
                br.donor_id,
                br.status,
                md.label AS status_name,
                donor.user_id AS donor_user_id,
                donor.username AS donor_name,
                donor.email AS donor_email,
                donor.phone AS donor_phone,
                donor.blood_group AS donor_blood_group,
                donor.address AS donor_address
            FROM blood_requests br
            LEFT JOIN master_data md ON md.id = br.status
            LEFT JOIN users donor ON donor.user_id = br.donor_id
            WHERE br.request_id = ?
              AND br.patient_id = ?
            LIMIT 1
            "
        );

        $stmt->execute([$requestId, $patientId]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }







    public function findAcceptedRequestsForDonor(int $donorId, int $acceptedStatus): array
    {
        $stmt = $this->db->prepare(
            "
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
                br.donor_id,
                br.status,
                md.label AS status_name,
                patient.user_id AS patient_user_id,
                patient.username AS patient_username,
                patient.email AS patient_email,
                patient.phone AS patient_phone,
                patient.address AS patient_address
            FROM blood_requests br
            LEFT JOIN master_data md ON md.id = br.status
            LEFT JOIN users patient ON patient.user_id = br.patient_id
            WHERE br.donor_id = ?
              AND br.status = ?
            ORDER BY br.created_at DESC
            "
        );

        $stmt->execute([$donorId, $acceptedStatus]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findDonorRequestDetail(int $requestId, int $donorId, int $acceptedStatus): array
    {
        $stmt = $this->db->prepare(
            "
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
                br.donor_id,
                br.status,
                md.label AS status_name,
                patient.user_id AS patient_user_id,
                patient.username AS patient_username,
                patient.email AS patient_email,
                patient.phone AS patient_phone,
                patient.address AS patient_address
            FROM blood_requests br
            LEFT JOIN master_data md ON md.id = br.status
            LEFT JOIN users patient ON patient.user_id = br.patient_id
            WHERE br.request_id = ?
              AND br.donor_id = ?
              AND br.status = ?
            LIMIT 1
            "
        );

        $stmt->execute([$requestId, $donorId, $acceptedStatus]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // ================= CREATE BLOOD REQUEST =================

    public function create(array $data): bool
    {

        $sql = "
            INSERT INTO blood_requests
            (
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

            VALUES
            (
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

            ':request_code' =>
            $data['request_code'],


            ':patient_id' =>
            $data['patient_id'],


            ':patient_name' =>
            $data['patient_name'],


            ':blood_group_needed' =>
            $data['blood_group_needed'],


            ':unit' =>
            $data['unit'],


            ':hospital_name' =>
            $data['hospital_name'],


            ':urgency' =>
            $data['urgency'],


            ':contact_phone' =>
            $data['contact_phone'],


            ':status' =>
            $data['status']

        ]);
    }







    // ================= FIND ALL REQUESTS =================

    public function findAll(): array
    {

        $sql = "
            SELECT
                br.*,
                md.label AS status_name

            FROM blood_requests br

            LEFT JOIN master_data md

                ON br.status = md.id

            ORDER BY br.created_at DESC
        ";


        $stmt = $this->db->prepare($sql);

        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }








    // ================= FIND DONOR MATCHING REQUESTS =================

    public function findPendingRequestsForDonor(
        string $bloodGroup
    ): array {

        if ($bloodGroup === '') {
            return [];
        }

        $pendingStatus = (new MasterDataRepository())->getId('REQUEST_STATUS', 'PENDING') ?? 7;

        $sql = "
            SELECT
                br.request_id,
                br.request_code,
                br.patient_name,
                br.blood_group_needed,
                br.unit,
                br.hospital_name,
                br.urgency,
                br.contact_phone,
                br.created_at,
                br.status,
                md.label AS status_name

            FROM blood_requests br

            LEFT JOIN master_data md

                ON br.status = md.id


            WHERE

                br.blood_group_needed = :blood_group
                AND br.status = :status

            ORDER BY br.created_at DESC
        ";



        $stmt = $this->db->prepare($sql);



        $stmt->execute([

            ':blood_group' => $bloodGroup,
            ':status' => $pendingStatus

        ]);



        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getMatchingDonors(string $bloodGroup): array
    {
        if ($bloodGroup === '') {
            return [];
        }

        $acceptedStatus = (new MasterDataRepository())->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;
        $eligibilityService = new \App\Donor\Application\UseCase\DonorDonationEligibilityService();

        $stmt = $this->db->prepare(
            "
            SELECT
                u.user_id,
                u.username,
                u.email,
                u.phone,
                u.blood_group,
                u.address,
                u.available,
                u.is_active,
                u.next_available_date,
                latest_request.created_at AS last_donation_date
            FROM users u
            LEFT JOIN (
                SELECT donor_id, MAX(created_at) AS created_at
                FROM blood_requests
                WHERE donor_id IS NOT NULL
                  AND status = ?
                GROUP BY donor_id
            ) latest_request ON latest_request.donor_id = u.user_id
            WHERE u.user_type_id = 2
              AND u.is_active = 1
              AND u.blood_group = ?
            ORDER BY u.username ASC
            "
        );

        $stmt->execute([$acceptedStatus, $bloodGroup]);

        $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_values(array_filter($donors, function (array $donor) use ($eligibilityService): bool {
            $eligibility = $eligibilityService->evaluate(
                (string)($donor['last_donation_date'] ?? ''),
                (string)($donor['next_available_date'] ?? '')
            );
            return $eligibility['is_available'];
        }));
    }

    public function acceptByAdmin(int $requestId, int $donorId, int $statusId): bool
    {
        $stmt = $this->db->prepare(
            "
            UPDATE blood_requests
            SET status = ?, donor_id = ?
            WHERE request_id = ?
            "
        );

        return $stmt->execute([$statusId, $donorId, $requestId]);
    }

    public function getPatientStats(int $patientId): array
    {
        // Total requests
        $stmt = $this->db->prepare("
        SELECT COUNT(*)
        FROM blood_requests
        WHERE patient_id = ?
    ");
        $stmt->execute([$patientId]);
        $total = (int)$stmt->fetchColumn();

        // Pending requests
        $stmt = $this->db->prepare("
        SELECT COUNT(*)
        FROM blood_requests
        WHERE patient_id = ?
        AND status = 7
    ");
        $stmt->execute([$patientId]);
        $pending = (int)$stmt->fetchColumn();

        // Accepted requests
        $stmt = $this->db->prepare("
        SELECT COUNT(*)
        FROM blood_requests
        WHERE patient_id = ?
        AND status = 8
    ");
        $stmt->execute([$patientId]);
        $accepted = (int)$stmt->fetchColumn();


        return [
            'total_requests'     => $total,
            'pending_requests'   => $pending,
            'accepted_requests'  => $accepted
        ];
    }








    // ================= UPDATE DONOR ACCEPT / DECLINE =================

    public function updateDonorDecision(

        int $requestId,

        int $donorId,

        int $statusId

    ): bool {


        $sql = "

            UPDATE blood_requests

            SET

                status = :status,

                donor_id = :donor_id


            WHERE request_id = :request_id

        ";


        $stmt = $this->db->prepare($sql);



        return $stmt->execute([

            ':status' => $statusId,

            ':donor_id' => $donorId,

            ':request_id' => $requestId

        ]);
    }

    public function countAcceptedByDonors(): int
    {
        $acceptedStatus = (new MasterDataRepository())->getId('REQUEST_STATUS', 'ACCEPTED') ?? 8;

        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM blood_requests
            WHERE donor_id IS NOT NULL
              AND status = ?
        ");

        $stmt->execute([$acceptedStatus]);

        return (int)$stmt->fetchColumn();
    }
}
