<?php

namespace Keepcloud\Laravel\Freshdesk\Tests;

use Freshdesk\Exceptions\InvalidConfigurationException;
use Keepcloud\Laravel\Freshdesk\Api;
use Keepcloud\Laravel\Freshdesk\FreshdeskServiceProvider;

class ServiceProviderTest extends TestCase
{
    public function test_it_merges_the_default_config(): void
    {
        $this->assertSame(30.0, config('freshdesk.http.timeout'));
        $this->assertSame(10.0, config('freshdesk.http.connect_timeout'));
    }

    public function test_it_registers_a_singleton_with_alias(): void
    {
        $api = $this->app->make('freshdesk');

        $this->assertInstanceOf(Api::class, $api);
        $this->assertSame($api, $this->app->make(Api::class));
        $this->assertSame($api, $this->app->make('freshdesk'));
    }

    public function test_it_fails_fast_when_credentials_are_missing(): void
    {
        config(['freshdesk.api_key' => null]);
        $this->app->forgetInstance('freshdesk');

        $this->expectException(InvalidConfigurationException::class);

        $this->app->make('freshdesk');
    }

    public function test_it_publishes_the_config_under_a_tag(): void
    {
        $paths = FreshdeskServiceProvider::pathsToPublish(FreshdeskServiceProvider::class, 'freshdesk-config');

        $this->assertCount(1, $paths);
        $this->assertSame(config_path('freshdesk.php'), array_values($paths)[0]);
    }

    public function test_http_options_are_passed_to_the_guzzle_client(): void
    {
        config(['freshdesk.http.timeout' => 5]);
        $this->app->forgetInstance('freshdesk');

        $sdk = $this->app->make('freshdesk')->sdk();
        $client = (fn () => $this->client)->call($sdk);

        $this->assertSame(5, $client->getConfig('timeout'));
        $this->assertSame(['test-key', 'X'], $client->getConfig('auth'));
    }
}
