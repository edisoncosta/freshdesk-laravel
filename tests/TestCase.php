<?php

namespace Keepcloud\Laravel\Freshdesk\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Keepcloud\Laravel\Freshdesk\FreshdeskServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var array<int, array<string, mixed>> */
    protected array $history = [];

    protected function getPackageProviders($app): array
    {
        return [FreshdeskServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return ['Freshdesk' => \Keepcloud\Laravel\Freshdesk\FreshdeskFacade::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('freshdesk.api_key', 'test-key');
        $app['config']->set('freshdesk.domain', 'acme');
    }

    /**
     * Queue fake responses for the SDK's Guzzle client and record the requests.
     */
    protected function mockResponses(array $responses): void
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->history));

        $this->app['config']->set('freshdesk.http.handler', $stack);
        $this->app->forgetInstance('freshdesk');
        \Keepcloud\Laravel\Freshdesk\FreshdeskFacade::clearResolvedInstance('freshdesk');
    }
}
