<?php

namespace Tests\Services;

use App\Models\Carrier;
use App\Repository\Contracts\CarrierRepositoryInterface;
use App\Services\CarrierService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class CarrierServiceTest extends TestCase
{
    private MockInterface $carrierRepositoryMock;

    private CarrierService $carrierService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->carrierRepositoryMock = Mockery::mock(CarrierRepositoryInterface::class);
        $this->carrierService = new CarrierService($this->carrierRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_first_or_create_calls_repository_with_correct_data(): void
    {
        $carrier = [
            '_id' => 'some-uuid',
            '_fantasia' => 'Test Carrier',
            '_cnpj' => '1234567',
        ];

        $expectedCarrier = new Carrier([
            'id' => 1,
            'uuid' => $carrier['_id'],
            'cnpj' => $carrier['_cnpj'],
            'name' => $carrier['_fantasia'],
        ]);

        $this->carrierRepositoryMock
            ->shouldReceive('firstOrCreate')
            ->once()
            ->with($carrier)
            ->andReturn($expectedCarrier);

        $result = $this->carrierService->firstOrCreate($carrier);

        $this->assertInstanceOf(Carrier::class, $result);
        $this->assertSame($expectedCarrier, $result);
        $this->assertEquals($carrier['_cnpj'], $result->cnpj);
        $this->assertEquals($carrier['_fantasia'], $result->name);
    }
}
