<?php

namespace Tests\Services;

use App\Models\Recipient;
use App\Models\RecipientAddress;
use App\Repository\Contracts\RecipientRepositoryInterface;
use App\Services\RecipientService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class RecipientServiceTest extends TestCase
{
    private MockInterface $recipientRepositoryMock;

    private RecipientService $recipientService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->recipientRepositoryMock = Mockery::mock(RecipientRepositoryInterface::class);
        $this->recipientService = new RecipientService($this->recipientRepositoryMock);
    }

    /**
     * Limpa os mocks após cada teste.
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_find_or_create_by_cpf_calls_repository_correctly(): void
    {
        $recipientApiData = [
            '_nome' => 'João da Silva',
            '_cpf' => '11122233344',
        ];

        $expectedDataForRepo = [
            'name' => 'João da Silva',
            'cpf' => '11122233344',
        ];

        $fakeRecipient = new Recipient($expectedDataForRepo);

        $this->recipientRepositoryMock
            ->shouldReceive('firstOrCreate')
            ->once()
            ->with($expectedDataForRepo)
            ->andReturn($fakeRecipient);

        $result = $this->recipientService->findOrCreateByCpf($recipientApiData);

        $this->assertSame($fakeRecipient, $result);
    }

    public function test_find_or_create_for_recipient_calls_relationship_on_model(): void
    {
        $addressData = ['street' => 'Rua dos Testes, 123'];

        $fakeAddress = new RecipientAddress($addressData);

        $recipientMock = Mockery::mock(Recipient::class);

        $addressRelationshipMock = Mockery::mock(HasMany::class);

        $recipientMock
            ->shouldReceive('addresses')
            ->once()
            ->andReturn($addressRelationshipMock);

        $addressRelationshipMock
            ->shouldReceive('firstOrCreate')
            ->once()
            ->with($addressData)
            ->andReturn($fakeAddress);

        $result = $this->recipientService->findOrCreateForRecipient($recipientMock, $addressData);

        $this->assertSame($fakeAddress, $result);
    }
}
