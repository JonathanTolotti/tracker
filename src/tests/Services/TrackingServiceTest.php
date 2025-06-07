<?php

namespace Services;

use App\Models\Delivery;
use App\Services\DeliveryService;
use App\Services\TrackingService;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class TrackingServiceTest extends TestCase
{
    private MockInterface $deliveryServiceMock;

    private TrackingService $trackingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deliveryServiceMock = Mockery::mock(DeliveryService::class);

        $this->trackingService = new TrackingService($this->deliveryServiceMock);
    }

    /**
     * Limpa os mocks após cada teste.
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_returns_deliveries_from_db_if_they_exist(): void
    {
        $cpf = '11111111111';

        $fakeDeliveries = new Collection(new Delivery(['uuid' => 'existing-uuid']));

        $this->deliveryServiceMock
            ->shouldReceive('getDeliveryByCpf')
            ->once()
            ->with($cpf)
            ->andReturn($fakeDeliveries);

        $this->deliveryServiceMock
            ->shouldNotReceive('createDelivery');

        $result = $this->trackingService->findOrCreateDeliveriesByCpf($cpf);

        $this->assertSame($fakeDeliveries, $result);
    }

    public function test_it_creates_deliveries_if_they_do_not_exist(): void
    {

        $cpf = '11111111111';

        $fakeCreatedDeliveries = new Collection(new Delivery(['uuid' => 'newly-created-uuid']));

        $this->deliveryServiceMock
            ->shouldReceive('getDeliveryByCpf')
            ->once()
            ->with($cpf)
            ->andReturn(new Collection);

        $this->deliveryServiceMock
            ->shouldReceive('createDelivery')
            ->once()
            ->with($cpf)
            ->andReturn($fakeCreatedDeliveries);

        $result = $this->trackingService->findOrCreateDeliveriesByCpf($cpf);

        $this->assertSame($fakeCreatedDeliveries, $result);
    }
}
