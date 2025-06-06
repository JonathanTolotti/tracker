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
     *
     * @return Collection
     */
    public function fetchAllDeliveries(): Collection
    {
        $jsonContent = File::get($this->deliveriesJsonPath);
        return collect(json_decode($jsonContent, true));
    }

    /**
     * Retorna todas as transportadoras mockadas no json
     *
     * @return Collection
     */
    public function fetchAllCarriers(): Collection
    {
        $jsonContent = File::get($this->carriersJsonPath);
        return collect(json_decode($jsonContent, true));
    }
}
