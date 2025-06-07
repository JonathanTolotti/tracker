<?php

namespace App\Services;

use App\Actions\CreateDeliveryAction;
use App\Models\Delivery;
use App\Repository\DeliveryRepository;
use App\Services\Contracts\ApiServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeliveryService
{
    protected DeliveryRepository $deliveryRepository;
    protected CreateDeliveryAction $createDeliveryAction;

    public function __construct(
        DeliveryRepository $deliveryRepository,
        CreateDeliveryAction $createDeliveryAction
    )
    {
        $this->deliveryRepository = $deliveryRepository;
        $this->createDeliveryAction = $createDeliveryAction;
    }

    /**
     * Buscamos os dados da API e criamos a entrega
     *
     * @param string $cpf
     * @return Collection
     */
    public function createDelivery(string $cpf): Collection
    {
        return $this->createDeliveryAction->execute($cpf);
    }

    /**
     * Busca as entregas pelo CPF do destinatário
     *
     * @param string $cpf
     * @return Collection|null
     */
    public function getDeliveryByCpf(string $cpf): ?Collection
    {
        return $this->deliveryRepository->findByRecipientCpf($cpf);
    }
}
