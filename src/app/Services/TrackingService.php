<?php

namespace App\Services;

use Illuminate\Support\Collection;

class TrackingService
{
    protected DeliveryService $deliveryService;

    public function __construct(
        DeliveryService $deliveryService
    ) {
        $this->deliveryService = $deliveryService;
    }

    /**
     * Se a entrega já existir no DB ela é retornada, caso contrário, consultamos a api e criamos.
     */
    public function findOrCreateDeliveriesByCpf(string $cpf): Collection
    {
        $deliveries = $this->deliveryService->getDeliveryByCpf($cpf);

        if ($deliveries->isEmpty()) {
            return $this->deliveryService->createDelivery($cpf);
        }

        return $deliveries;
    }
}
