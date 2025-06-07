<?php

namespace App\Services;

use App\Services\Contracts\ApiServiceInterface;
use http\Exception\RuntimeException;
use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class JsonApiMockService implements ApiServiceInterface
{
    private string $carriersJsonPath;

    private string $deliveriesJsonPath;

    public function __construct(Repository $config)
    {
        $this->carriersJsonPath = $config->get('data_sources.carriers_api_path');
        $this->deliveriesJsonPath = $config->get('data_sources.deliveries_api_path');

        if (blank($this->carriersJsonPath) || blank($this->deliveriesJsonPath)) {
            Log::error('ApiService: Caminho do arquivo JSON não configurado.');
            throw new RuntimeException('Caminho do arquivo JSON não configurado');
        }
    }

    /**
     * Retorna todas as entregas mockadas do json
     */
    public function fetchAllDeliveries(): Collection
    {
        $jsonContent = File::get($this->deliveriesJsonPath);
        $decodedData = json_decode($jsonContent, true);

        return collect($decodedData['data'] ?? []);
    }

    /**
     * Retorna todas as transportadoras mockadas no json
     */
    public function fetchAllCarriers(): Collection
    {
        $jsonContent = File::get($this->carriersJsonPath);
        $decodedData = json_decode($jsonContent, true);

        return collect($decodedData['data'] ?? []);
    }

    /**
     * Filtra nas entregas pelo CPF informado
     */
    public function findDeliveriesByCpf(string $cpf): Collection
    {
        $allDeliveries = $this->fetchAllDeliveries();
        $filteredDeliveries = collect();

        if ($allDeliveries->isNotEmpty()) {
            return $allDeliveries->where('_destinatario._cpf', $cpf)->values();
        }

        return $filteredDeliveries;
    }

    /**
     * Busca a transportadora pelo ID
     */
    public function findCarrierById(string $uuid): Collection
    {
        $allCarriers = $this->fetchAllCarriers();
        $filteredCarrier = collect();

        if ($allCarriers->isNotEmpty()) {
            return $allCarriers->where('_id', $uuid)->values();
        }

        return $filteredCarrier;
    }
}
