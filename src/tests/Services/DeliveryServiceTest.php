<?php

namespace Services;

use App\Actions\CreateDeliveryAction;
use App\Models\Delivery;
use App\Repository\Contracts\DeliveryRepositoryInterface;
use App\Services\DeliveryService;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class DeliveryServiceTest extends TestCase
{
    private MockInterface $deliveryRepositoryMock;

    private MockInterface $createDeliveryActionMock;

    private DeliveryService $deliveryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deliveryRepositoryMock = Mockery::mock(DeliveryRepositoryInterface::class);
        $this->createDeliveryActionMock = Mockery::mock(CreateDeliveryAction::class);

        $this->deliveryService = new DeliveryService(
            $this->deliveryRepositoryMock,
            $this->createDeliveryActionMock
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_delivery_by_cpf_calls_repository_method(): void
    {
        $cpf = '11111111111';
        $fakeDeliveriesFromDb = new Collection([new Delivery]);

        $this->deliveryRepositoryMock
            ->shouldReceive('findByRecipientCpf')
            ->once()
            ->with($cpf)
            ->andReturn($fakeDeliveriesFromDb);

        $this->createDeliveryActionMock->shouldNotReceive('execute');

        $result = $this->deliveryService->getDeliveryByCpf($cpf);

        $this->assertSame($fakeDeliveriesFromDb, $result);
    }

    public function test_create_delivery_calls_action_execute_method(): void
    {
        $cpf = '11111111111';
        $fakeDeliveriesFromAction = new Collection([new Delivery(['uuid' => 'new-uuid'])]);

        $this->createDeliveryActionMock
            ->shouldReceive('execute')
            ->once()
            ->with($cpf)
            ->andReturn($fakeDeliveriesFromAction);

        $this->deliveryRepositoryMock->shouldNotReceive('findByRecipientCpf');

        $result = $this->deliveryService->createDelivery($cpf);

        $this->assertSame($fakeDeliveriesFromAction, $result);
    }
}
