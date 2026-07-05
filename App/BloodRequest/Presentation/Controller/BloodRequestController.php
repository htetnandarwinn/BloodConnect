<?php

namespace App\BloodRequest\Presentation\Controller;

use App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository;
use App\Shared\Helpers\Session;
use App\Shared\Presentation\View\patientView;
use App\Notification\Infrastructure\Persistence\NotificationRepository;

class BloodRequestController
{
    private BloodRequestRepository $repository;

    public function __construct()
    {
        $this->repository = new BloodRequestRepository();
    }

    /**
     * Show Request Blood page
     */
    public function create()
    {
        Session::start();

        if (!Session::has('user_id')) {
            header('Location: /BloodConnect/public/login');
            exit;
        }

        return patientView::render('request_blood');
    }

    /**
     * Store new blood request
     */
    public function store()
    {
        Session::start();

        if (!Session::has('user_id')) {
            header('Location: /BloodConnect/public/login');
            exit;
        }

        // Generate request code
        $requestCode = 'REQ' . date('YmdHis');

        $data = [
            'request_code'       => $requestCode,
            'patient_id'         => Session::get('user_id'),
            'patient_name'       => trim($_POST['patient_name']),
            'blood_group_needed' => trim($_POST['blood_group_needed']),
            'hospital_name'      => trim($_POST['hospital_name']),
            'urgency'            => trim($_POST['urgency']),
            'contact_phone'      => trim($_POST['contact_phone']),
            'unit'               => (int) $_POST['unit'],

            // Pending status
            'status'             => 28
        ];

        // Save blood request
        $saved = $this->repository->create($data);

        if ($saved) {

            // Create notification
            $notificationRepo = new NotificationRepository();

            $notificationRepo->create(
                Session::get('user_id'),
                'Blood Request Submitted',
                'Your blood request has been submitted successfully and is now Pending.',
                'REQUEST'
            );

            header('Location: /BloodConnect/public/patient/dashboard?page=my-requests');
            exit;
        }

        die('Failed to submit blood request.');
    }

    /**
     * List blood requests
     */
    public function list()
    {
        // TODO
    }

    /**
     * Blood request details
     */
    public function details(int $id)
    {
        // TODO
    }
}
