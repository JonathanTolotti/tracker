<?php

namespace Tests\Services;

use App\Services\JsonApiMockService;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\File;
use Mockery;
use Tests\TestCase;

class JsonApiMockServiceTest extends TestCase
{
    private $mockConfig;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockConfig = Mockery::mock(Repository::class);
        $this->app->instance(Repository::class, $this->mockConfig);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function mockFileContent(string $path, ?string $content, bool $exists = true): void
    {
        File::shouldReceive('exists')
            ->with($path)
            ->andReturn($exists);

        if ($exists && $content !== null) {
            File::shouldReceive('get')
                ->with($path)
                ->andReturn($content);
        } elseif ($exists && $content === null) {
            File::shouldReceive('get')
                ->with($path)
                ->andThrow(new RuntimeException("Simulated file read error for path: {$path}"));
        }
    }

    public function test_fetch_all_deliveries_returns_data_from_json(): void
    {
        $fakeDeliveriesPath = 'path/to/fake_deliveries.json';
        $fakeJsonContent = '{
            "status":1, "code":200, "message":"OK", "description":"Desc",
            "data":[ {"_id":"delivery1"}, {"_id":"delivery2"} ]
        }';

        $this->mockConfig->shouldReceive('get')->with('data_sources.deliveries_api_path')->andReturn($fakeDeliveriesPath);
        $this->mockConfig->shouldReceive('get')->with('data_sources.carriers_api_path')->andReturn('dummy_carrier_path.json');

        $this->mockFileContent($fakeDeliveriesPath, $fakeJsonContent);

        $apiService = new JsonApiMockService($this->mockConfig);
        $deliveries = $apiService->fetchAllDeliveries();

        $this->assertNotNull($deliveries);
        $this->assertEquals(1, $deliveries->values('status')[0]);
        $this->assertEquals(200, $deliveries->values('status')[1]);
    }

    public function test_fetch_all_carriers_returns_data_from_json(): void
    {
        $fakeCarriersPath = 'path/to/fake_carriers.json';
        $fakeJsonContent = '{
            "status":1, "code":200, "message":"OK", "description":"Desc",
            "data":[ {"_id":"carrier1"}, {"_id":"carrier2"} ]
        }';

        $this->mockConfig->shouldReceive('get')->with('data_sources.deliveries_api_path')->andReturn($fakeCarriersPath);
        $this->mockConfig->shouldReceive('get')->with('data_sources.carriers_api_path')->andReturn('dummy_carrier_path.json');

        $this->mockFileContent($fakeCarriersPath, $fakeJsonContent);

        $apiService = new JsonApiMockService($this->mockConfig);
        $carriers = $apiService->fetchAllDeliveries();

        $this->assertNotNull($carriers);
        $this->assertEquals(1, $carriers->values('status')[0]);
        $this->assertEquals(200, $carriers->values('status')[1]);
    }
}
