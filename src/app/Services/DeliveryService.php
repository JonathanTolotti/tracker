<?php

namespace App\Services;

use App\Models\Delivery;
use App\Repository\DeliveryRepository;
use App\Services\Contracts\ApiServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeliveryService
{
    protected ApiServiceInterface $apiService;
    protected CarrierService $carrierService;
    protected SenderService $senderService;
    protected RecipientService $recipientService;
    protected DeliveryRepository $deliveryRepository;


    public function __construct(
        ApiServiceInterface $apiService,
        CarrierService $carrierService,
        SenderService $senderService,
        RecipientService $recipientService,
        DeliveryRepository $deliveryRepository
    )
    {
        $this->apiService = $apiService;
        $this->carrierService = $carrierService;
        $this->senderService = $senderService;
        $this->recipientService = $recipientService;
        $this->deliveryRepository = $deliveryRepository;
    }
    public function createDelivery(string $cpf): Collection
    {
        $deliveries = $this->apiService->findDeliveriesByCpf($cpf);
        $persistedDeliveries = new Collection();

            $deliveries->each(function ($deliveryData) use (&$persistedDeliveries) {
                try {
                    $carrier = $this->carrierService->findOrCreate($deliveryData['_id_transportadora']);
                    $sender = $this->senderService->findOrCreateByName($deliveryData['_remetente']['_nome']);
                    $recipient = $this->recipientService->findOrCreateByCpf($deliveryData['_destinatario']);

                    $recipientAddress = $deliveryData['_destinatario'];

                    $address = $this->recipientService->findOrCreateForRecipient($recipient, [
                        'street'    => $recipientAddress['_endereco'],
                        'state'     => $recipientAddress['_estado'],
                        'zip_code'  => $recipientAddress['_cep'],
                        'country'   => $recipientAddress['_pais'],
                        'latitude'  => $recipientAddress['_geolocalizao']['_lat'],
                        'longitude' => $recipientAddress['_geolocalizao']['_lng'],
                    ]);


                    $delivery = $this->deliveryRepository->firstOrCreate(
                        [
                            'uuid' => $deliveryData['_id'],
                            'carrier_id'           => $carrier->id,
                            'sender_id'            => $sender->id,
                            'recipient_id'         => $recipient->id,
                            'recipient_address_id' => $address->id,
                            'volumes'              => $deliveryData['_volumes'],
                        ]
                    );
                        $statusesData = array_map(function ($event) use ($delivery) {
                            return [
                                'delivery_id'     => $delivery->id,
                                'message'         => $event['message'],
                                'event_timestamp' => Carbon::parse($event['date']),
                            ];
                        }, $deliveryData['_rastreamento']);

                     $delivery->statuses()->upsert($statusesData, ['delivery_id', 'event_timestamp', 'message']);

                    $delivery->load(['carrier', 'sender', 'recipient', 'shippingAddress', 'statuses']);

                    $persistedDeliveries->push($delivery);

                } catch (\Exception $e) {
                    Log::error("Falha ao sincronizar entrega com API ID {$deliveryData['_id']}: " . $e->getMessage());
                    dd($e->getMessage());
                    throw $e;
                }
            });

            return $persistedDeliveries;
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
