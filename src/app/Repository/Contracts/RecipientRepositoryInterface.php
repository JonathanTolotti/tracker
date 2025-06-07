<?php

namespace App\Repository\Contracts;

use App\Models\Recipient;

interface RecipientRepositoryInterface
{
    public function firstOrCreate(array $recipientToCreate): Recipient;
}
