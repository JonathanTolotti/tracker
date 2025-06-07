<?php

namespace Tests\Feature\Actions;

use App\Actions\CreateDeliveryAction;
use App\Models\Delivery;
use App\Services\Contracts\ApiServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateDeliveryActionTest extends TestCase
{
    use RefreshDatabase;

    private MockInterface $apiServiceMock;

    private MockInterface $carrierServiceMock;

    private MockInterface $senderServiceMock;

    private MockInterface $recipientServiceMock;

    private MockInterface $deliveryRepositoryMock;

    private CreateDeliveryAction $action;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_correctly_persists_deliveries_from_api_data(): void
    {
        $cpf = '12345678955';

        $fakeApiDelivery = [
            '_id' => 'delivery-uuid-1',
            '_id_transportadora' => 'carrier-uuid-1',
            '_remetente' => ['_nome' => 'Test Sender'],
            '_destinatario' => [
                '_cpf' => $cpf,
                '_nome' => 'Test Recipient',
                '_endereco' => '123 Test St',
                '_estado' => 'TS',
                '_cep' => '12345-678',
                '_pais' => 'Testland',
                '_geolocalizao' => ['_lat' => '0', '_lng' => '0'],
            ],
            '_volumes' => 2,
            '_rastreamento' => [['message' => 'ENTREGA CRIADA', 'date' => now()->toIso8601String()]],
        ];

        $fakeApiCarrier = ['_id' => 'carrier-uuid-1', '_cnpj' => '11222333000144', '_fantasia' => 'Test Carrier'];

        $apiServiceMock = Mockery::mock(ApiServiceInterface::class);

        $apiServiceMock->shouldReceive('findDeliveriesByCpf')->with($cpf)->andReturn(collect([$fakeApiDelivery]));
        $apiServiceMock->shouldReceive('fetchAllCarriers')->andReturn(collect([$fakeApiCarrier]));

        $this->app->instance(ApiServiceInterface::class, $apiServiceMock);
        $action = $this->app->make(CreateDeliveryAction::class);
        $result = $action->execute($cpf);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);

        $persistedDelivery = $result->first();
        $this->assertInstanceOf(Delivery::class, $persistedDelivery, 'O item na coleção deveria ser um model Delivery.');
        $this->assertEquals('delivery-uuid-1', $persistedDelivery->uuid, 'O UUID da entrega retornada está incorreto.');
        $this->assertNotNull($persistedDelivery->carrier, 'O relacionamento com a transportadora deveria ter sido carregado.');
        $this->assertEquals('Test Carrier', $persistedDelivery->carrier->name, 'O nome da transportadora no relacionamento está incorreto.');
        $this->assertCount(1, $persistedDelivery->statuses, 'A entrega retornada deveria ter 1 status carregado.');

        $this->assertDatabaseCount('carriers', 1);
        $this->assertDatabaseHas('carriers', [
            'uuid' => 'carrier-uuid-1',
            'cnpj' => '11222333000144',
            'name' => 'Test Carrier',
        ]);

        $this->assertDatabaseCount('senders', 1);
        $this->assertDatabaseHas('senders', [
            'name' => 'Test Sender',
        ]);

        $this->assertDatabaseCount('recipients', 1);
        $this->assertDatabaseHas('recipients', [
            'cpf' => $cpf,
            'name' => 'Test Recipient',
        ]);

        $this->assertDatabaseCount('recipient_addresses', 1);
        $this->assertDatabaseHas('recipient_addresses', [
            'street' => '123 Test St',
            'state' => 'TS',
        ]);

        $this->assertDatabaseCount('deliveries', 1);
        $this->assertDatabaseHas('deliveries', [
            'uuid' => 'delivery-uuid-1',
            'volumes' => 2,
        ]);

        $this->assertDatabaseCount('delivery_statuses', 1);
        $this->assertDatabaseHas('delivery_statuses', [
            'message' => 'ENTREGA CRIADA',
        ]);

    }
}
