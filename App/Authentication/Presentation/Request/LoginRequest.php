<?php

namespace App\Authentication\Presentation\Request;

use App\Shared\Validation\Validator;

class LoginRequest
{
    public function validate(array $data): array
    {
        $validator = new Validator();

        $loginValue = trim((string)($data['login'] ?? $data['email'] ?? ''));
        $passwordValue = $data['password'] ?? '';

        $validator
            ->required('login', $loginValue)
            ->required('password', $passwordValue);

        if ($loginValue !== '' && filter_var($loginValue, FILTER_VALIDATE_EMAIL)) {
            $validator->email('login', $loginValue);
        }

        if ($validator->fails()) {
            throw new \Exception(json_encode($validator->errors()));
        }

        return [
            'email' => $loginValue,
            'login' => $loginValue,
            'password' => $passwordValue,
        ];
    }
}
