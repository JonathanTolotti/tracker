<?php

namespace App\Services;

use App\Actions\CreateDeliveryAction;
use App\Repository\Contracts\DeliveryRepositoryInterface;
use Illuminate\Support\Collection;

class DeliveryService
{
    protected DeliveryRepositoryInterface $deliveryRepository;

    protected CreateDeliveryAction $createDeliveryAction;

    public function __construct(
        DeliveryRepositoryInterface $deliveryRepository,
        CreateDeliveryAction $createDeliveryAction
    ) {
        $this->deliveryRepository = $deliveryRepository;
        $this->createDeliveryAction = $createDeliveryAction;
    }

    /**
     * Buscamos os dados da API e criamos a entrega
     */
    public function createDelivery(string $cpf): Collection
    {
        return $this->createDeliveryAction->execute($cpf);
    }

    /**
     * Busca as entregas pelo CPF do destinatário
     */
    public function getDeliveryByCpf(string $cpf): ?Collection
    {
        return $this->deliveryRepository->findByRecipientCpf($cpf);
    }
}
