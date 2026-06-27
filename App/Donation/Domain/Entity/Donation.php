<?php

namespace App\Donation\Domain\Entity;

class Donation
{
    public int $id;
    public int $donorId;
    public string $date;
}
