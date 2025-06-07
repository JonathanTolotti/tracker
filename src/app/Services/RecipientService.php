<?php

namespace App\Services;

use App\Models\Recipient;
use App\Models\RecipientAddress;
use App\Repository\RecipientRepository;

class RecipientService
{
    protected RecipientRepository $recipientRepository;

    public function __construct(RecipientRepository $recipientRepository)
    {
        $this->recipientRepository = $recipientRepository;
    }

    /**
     * Busca ou atualiza um destinatário pelo CPF
     *
     * @param array $recipient
     * @return Recipient
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
     *
     * @param Recipient $recipient
     * @param array $address
     * @return RecipientAddress
     */
    public function findOrCreateForRecipient(Recipient $recipient, array $address): RecipientAddress
    {
        return $recipient->addresses()->firstOrCreate($address);
    }

}
