<?php

namespace App\Repository;

use App\Models\Sender;
use App\Repository\Contracts\SenderRepositoryInterface;

class SenderRepository implements SenderRepositoryInterface
{
    /**
     * Cria um novo remetente
     */
    public function firstOrCreate(array $senderToCreate): Sender
    {
        return Sender::query()->firstOrCreate($senderToCreate);
    }
}
