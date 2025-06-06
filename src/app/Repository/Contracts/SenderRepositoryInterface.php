<?php

namespace App\Repository\Contracts;

use App\Models\Sender;

interface SenderRepositoryInterface
{
    public function findByName(string $name): ?Sender;

    public function create(array $senderToCreate): Sender;
}
