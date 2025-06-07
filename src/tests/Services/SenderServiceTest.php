<?php

namespace Services;

use App\Models\Sender;
use App\Repository\Contracts\SenderRepositoryInterface;
use App\Services\SenderService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class SenderServiceTest extends TestCase
{
    private MockInterface $senderRepositoryMock;

    private SenderService $senderService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->senderRepositoryMock = Mockery::mock(SenderRepositoryInterface::class);

        $this->senderService = new SenderService($this->senderRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_find_or_create_by_name_formats_name_and_calls_repository(): void
    {
        $rawName = '  Test Name ';

        $expectedFormattedName = 'Test Name';

        $fakeSender = new Sender(['name' => $expectedFormattedName]);

        $this->senderRepositoryMock
            ->shouldReceive('firstOrCreate')
            ->once()
            ->with(['name' => $expectedFormattedName])
            ->andReturn($fakeSender);

        $result = $this->senderService->findOrCreateByName($rawName);

        $this->assertSame($fakeSender, $result, 'O serviço não retornou o model esperado do repositório.');
        $this->assertEquals($expectedFormattedName, $result->name, 'O nome no model retornado não foi formatado corretamente.');
    }
}
