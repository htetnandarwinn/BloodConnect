<?php

namespace App\Notification\Domain\Entity;

class Notification
{
    public int $id;
    public int $userId;
    public string $message;
}
