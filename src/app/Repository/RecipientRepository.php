<?php

namespace App\Repository;

use App\Models\Recipient;
use App\Repository\Contracts\RecipientRepositoryInterface;

class RecipientRepository implements RecipientRepositoryInterface
{

    /**
     * Busca um destinatário pelo CPF
     *
     * @param string $cpf
     * @return Recipient|null
     */
    public function findByCpf(string $cpf): ?Recipient
    {
        return  Recipient::query()->where('cpf', $cpf)->first();
    }

    /**
     * Cria um novo destinatário
     *
     * @param array $recipientToCreate
     * @return Recipient
     */
    public function create(array $recipientToCreate): Recipient
    {
        return  Recipient::query()->create($recipientToCreate);
    }
}
