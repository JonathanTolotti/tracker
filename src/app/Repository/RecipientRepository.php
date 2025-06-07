<?php

namespace App\Repository;

use App\Models\Recipient;
use App\Repository\Contracts\RecipientRepositoryInterface;

class RecipientRepository implements RecipientRepositoryInterface
{

    /**
     * Cria um novo destinatário
     *
     * @param array $recipientToCreate
     * @return Recipient
     */
    public function firstOrCreate(array $recipientToCreate): Recipient
    {
        return  Recipient::query()->firstOrCreate($recipientToCreate);
    }
}
