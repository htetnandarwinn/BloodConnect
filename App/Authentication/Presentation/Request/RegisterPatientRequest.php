<?php

namespace App\Authentication\Presentation\Request;

use App\Shared\Validation\Validator;

class RegisterPatientRequest
{
    public function validate(array $data): array
    {
        $validator = new Validator();
        $password = $data['password'] ?? '';
        $phone = $data['phone'] ?? '';

        if (strlen($password) < 8) {
            throw new \Exception(json_encode(['password' => ['Password must be at least 8 characters.']]));
        }

        if (strlen($phone) !== 11) {
            throw new \Exception(json_encode(['phone' => ['Phone must be 11 characters.']]));
        }

        $validator
            ->required('username', $data['username'] ?? '')

            ->required('email', $data['email'] ?? '')
            ->email('email', $data['email'] ?? '')

            ->required('phone', $phone)

            ->required('password', $data['password'] ?? '');

        if ($validator->fails()) {
            throw new \Exception(json_encode($validator->errors()));
        }

        return $data;
    }
}
