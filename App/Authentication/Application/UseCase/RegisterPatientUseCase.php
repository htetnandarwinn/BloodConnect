<?php

namespace App\Authentication\Application\UseCase;

require_once __DIR__ . '/../../Infrastructure/Persistence/AuthRepository.php';

use App\Authentication\Infrastructure\Persistence\AuthRepository;

class RegisterPatientUseCase
{
    public function execute(array $data)
    {
        $repo = new AuthRepository();
        return $repo->registerPatient($data);
    }
}
