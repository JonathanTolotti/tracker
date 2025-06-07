<?php

namespace App\Services;

use App\Models\Sender;
use App\Repository\Contracts\SenderRepositoryInterface;

class SenderService
{
    protected SenderRepositoryInterface $senderRepository;

    public function __construct(SenderRepositoryInterface $senderRepository)
    {
        $this->senderRepository = $senderRepository;
    }

    public function findOrCreateByName(string $name): Sender
    {
        $name = trim(ucwords($name));

        return $this->senderRepository->firstOrCreate([
            'name' => $name,
        ]);
    }
}
