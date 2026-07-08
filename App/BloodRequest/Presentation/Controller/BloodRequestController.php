<?php

namespace App\BloodRequest\Presentation\Controller;

use App\BloodRequest\Infrastructure\Persistence\BloodRequestRepository;
use App\Shared\Helpers\Session;
use App\Shared\Presentation\View\patientView;
use App\Notification\Infrastructure\Persistence\NotificationRepository;
use App\Shared\Infrastructure\Activity\ActivityLogger;
use App\User\Infrastructure\Persistence\UserRepository;
use App\Shared\Infrastructure\Persistence\MasterDataRepository;

class BloodRequestController
{
    private BloodRequestRepository $repository;


    public function __construct()
    {
        $this->repository = new BloodRequestRepository();
    }


    /**
     * Show Request Blood Page
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
     * Store New Blood Request
     */
    public function store()
    {
        Session::start();


        if (!Session::has('user_id')) {
            header('Location: /BloodConnect/public/login');
            exit;
        }


        $requestCode = 'REQ' . date('YmdHis');


        $masterRepo = new MasterDataRepository();


        $pendingStatus = $masterRepo->getId(
            'REQUEST_STATUS',
            'PENDING'
        );


        if (!$pendingStatus) {
            die("Pending status not found");
        }



        $data = [

            'request_code' => $requestCode,

            'patient_id' => Session::get('user_id'),

            'patient_name' => trim($_POST['patient_name']),

            'blood_group_needed' => trim($_POST['blood_group_needed']),

            'hospital_name' => trim($_POST['hospital_name']),

            'urgency' => trim($_POST['urgency']),

            'contact_phone' => trim($_POST['contact_phone']),

            'unit' => (int) $_POST['unit'],

            'status' => $pendingStatus

        ];



        $saved = $this->repository->create($data);



        if (!$saved) {

            die("Failed to create blood request");
        }



        // Activity Log

        $logger = new ActivityLogger();


        $logger->log(

            Session::get('user_id'),

            Session::get('username'),

            'BLOOD_REQUEST_CREATED',

            "Blood request {$requestCode} created"

        );




        // Notifications

        $notificationRepo = new NotificationRepository();



        // Patient notification

        $notificationRepo->create(

            Session::get('user_id'),

            'Blood Request Submitted',

            'Your blood request is now pending.',

            'REQUEST'

        );




        // Admin notification

        $userRepo = new UserRepository();


        $admins = $userRepo->getAdmins();

        $matchingDonors = $this->repository->getMatchingDonors($data['blood_group_needed']);

        foreach ($matchingDonors as $donor) {
            $notificationRepo->create(
                (int)$donor['user_id'],
                'New Blood Request',
                sprintf(
                    'Patient %s has requested %s blood. Please review the request.',
                    $data['patient_name'],
                    $data['blood_group_needed']
                ),
                'REQUEST'
            );
        }



        foreach ($admins as $admin) {


            $message = sprintf(

                'New blood request %s from %s (%s)',

                $requestCode,

                $data['patient_name'],

                $data['blood_group_needed']

            );


            $notificationRepo->create(

                $admin['user_id'],

                'New Blood Request',

                $message,

                'REQUEST'

            );
        }



        header(
            'Location: /BloodConnect/public/patient/dashboard?page=my-requests'
        );

        exit;
    }



    public function list() {}



    public function details(int $id) {}
}
