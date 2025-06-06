<?php

namespace App\Repository;

use App\Models\Sender;
use App\Repository\Contracts\SenderRepositoryInterface;

class SenderRepository implements SenderRepositoryInterface
{

    /**
     * Busca um remetente pelo nome
     *
     * @param string $name
     * @return Sender|null
     */
    public function findByName(string $name): ?Sender
    {
        return Sender::query()->where('name', $name)->first();
    }

    /**
     * Cria um novo remetente
     *
     * @param array $senderToCreate
     * @return Sender
     */
    public function create(array $senderToCreate): Sender
    {
        return Sender::query()->create($senderToCreate);
    }
}
