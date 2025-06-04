<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface ApiServiceInterface
{
    /**
     * @return Collection
     */
    public function fetchAllDeliveries(): Collection;

    /**
     * @return Collection
     */
    public function fetchAllCarriers(): Collection;
}
