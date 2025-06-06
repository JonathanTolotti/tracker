<?php

namespace App\Repository\Contracts;

use App\Models\Recipient;

interface RecipientRepositoryInterface
{
    public function findByCpf(string $cpf): ?Recipient;

    public function create(array $recipientToCreate): Recipient;
}
