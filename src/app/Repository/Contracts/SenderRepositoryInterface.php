<?php

namespace App\Repository\Contracts;

use App\Models\Sender;

interface SenderRepositoryInterface
{
    public function firstOrCreate(array $senderToCreate): Sender;
}
