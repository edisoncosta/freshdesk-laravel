<?php

namespace Keepcloud\Laravel\Freshdesk\Tests;

use Freshdesk\Exceptions\ApiException;
use Freshdesk\Exceptions\NotFoundException;
use Freshdesk\Resources;
use GuzzleHttp\Psr7\Response;
use Keepcloud\Laravel\Freshdesk\Api;
use Keepcloud\Laravel\Freshdesk\FreshdeskFacade as Freshdesk;
use PHPUnit\Framework\Attributes\DataProvider;

class ApiTest extends TestCase
{
    public static function resources(): array
    {
        return [
            ['agents', Resources\Agent::class],
            ['companies', Resources\Company::class],
            ['contacts', Resources\Contact::class],
            ['groups', Resources\Group::class],
            ['tickets', Resources\Ticket::class],
            ['timeEntries', Resources\TimeEntry::class],
            ['conversations', Resources\Conversation::class],
            ['discussions', Resources\Discussion::class],
            ['categories', Resources\Discussion::class],
            ['forums', Resources\Forum::class],
            ['topics', Resources\Topic::class],
            ['comments', Resources\Comment::class],
            ['solutions', Resources\Solution::class],
            ['folders', Resources\Folder::class],
            ['articles', Resources\Article::class],
            ['emailConfigs', Resources\EmailConfig::class],
            ['products', Resources\Product::class],
            ['businessHours', Resources\BusinessHour::class],
            ['slaPolicies', Resources\SLAPolicy::class],
        ];
    }

    #[DataProvider('resources')]
    public function test_every_resource_is_exposed(string $method, string $class): void
    {
        $this->assertInstanceOf($class, $this->app->make(Api::class)->{$method}());
        $this->assertInstanceOf($class, Freshdesk::{$method}());
    }

    public function test_resource_calls_return_decoded_json(): void
    {
        $this->mockResponses([
            new Response(200, ['X-RateLimit-Remaining' => '99'], json_encode(['id' => 42, 'subject' => 'Help'])),
        ]);

        $ticket = Freshdesk::tickets()->view(42);

        $this->assertSame(['id' => 42, 'subject' => 'Help'], $ticket);
        $this->assertSame(['99'], Freshdesk::lastResponseHeaders()['X-RateLimit-Remaining']);

        $request = $this->history[0]['request'];
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('https://acme.freshdesk.com/api/v2/tickets/42', (string) $request->getUri());
    }

    public function test_api_errors_surface_as_sdk_exceptions(): void
    {
        $this->mockResponses([
            new Response(404, [], json_encode(['code' => 'not_found'])),
        ]);

        try {
            Freshdesk::tickets()->view(1);
            $this->fail('Expected an ApiException.');
        } catch (ApiException $e) {
            $this->assertInstanceOf(NotFoundException::class, $e);
            $this->assertSame(404, $e->getStatusCode());
        }
    }
}
