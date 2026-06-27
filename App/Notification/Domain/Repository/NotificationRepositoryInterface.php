<?php

namespace App\Notification\Domain\Repository;

interface NotificationRepositoryInterface
{
    public function create(array $data);
    public function getByUser(int $userId);
}
