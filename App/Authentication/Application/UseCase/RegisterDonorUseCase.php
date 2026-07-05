<?php

namespace App\Authentication\Application\UseCase;

use App\Authentication\Infrastructure\Persistence\AuthRepository;

class RegisterDonorUseCase
{
    public function execute(array $data)
    {
        $repo = new AuthRepository();
        return $repo->registerDonor($data);
    }
}
