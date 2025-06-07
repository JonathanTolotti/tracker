<?php

namespace App\Services;

use App\Models\Recipient;
use App\Models\RecipientAddress;
use App\Repository\Contracts\RecipientRepositoryInterface;

class RecipientService
{
    protected RecipientRepositoryInterface $recipientRepository;

    public function __construct(RecipientRepositoryInterface $recipientRepository)
    {
        $this->recipientRepository = $recipientRepository;
    }

    /**
     * Busca ou atualiza um destinatário pelo CPF
     */
    public function findOrCreateByCpf(array $recipient): Recipient
    {
        return $this->recipientRepository->firstOrCreate([
            'name' => $recipient['_nome'],
            'cpf' => $recipient['_cpf'],
        ]);
    }

    /**
     * Usa o destinatário para criar um endereço já vinculado
     */
    public function findOrCreateForRecipient(Recipient $recipient, array $address): RecipientAddress
    {
        return $recipient->addresses()->firstOrCreate($address);
    }
}
