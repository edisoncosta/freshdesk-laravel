# Freshdesk for Laravel

[![Packagist](https://img.shields.io/packagist/v/keepcloud/freshdesk-laravel)](https://packagist.org/packages/keepcloud/freshdesk-laravel)
[![tests](https://github.com/edisoncosta/freshdesk-laravel/actions/workflows/tests.yml/badge.svg)](https://github.com/edisoncosta/freshdesk-laravel/actions/workflows/tests.yml)

Laravel integration for the Freshdesk API v2, built on top of
[keepcloud/freshdesk-php-sdk](https://github.com/edisoncosta/freshdesk-php-sdk).

| Package | Laravel | PHP | SDK |
|---|---|---|---|
| 2.x | 12, 13 | 8.2+ (Laravel 13: 8.3+) | ^2.0 |
| 1.x | 7, 8 | 7.2.5+ | ^1.0 |

## Installation

```sh
composer require keepcloud/freshdesk-laravel
```

The service provider and the `Freshdesk` facade are registered automatically
(package auto-discovery).

## Configuration

Add your credentials to `.env`:

```dotenv
FRESHDESK_API_KEY=your_api_key
FRESHDESK_DOMAIN=acme          # for https://acme.freshdesk.com

# Optional (seconds)
FRESHDESK_TIMEOUT=30
FRESHDESK_CONNECT_TIMEOUT=10
```

To customize the config file, publish it:

```sh
php artisan vendor:publish --tag=freshdesk-config
```

This creates `config/freshdesk.php`. Any Guzzle option placed under the `http`
key is passed to the HTTP client (authentication cannot be overridden).

## Usage

Every resource method returns the decoded JSON response as an array
(or `null` for empty responses such as `DELETE`).

```php
use Freshdesk; // or Keepcloud\Laravel\Freshdesk\FreshdeskFacade

// Tickets
$ticket  = Freshdesk::tickets()->create([
    'email' => 'customer@example.com',
    'subject' => 'Need help',
    'description' => 'Details...',
    'status' => 2,
    'priority' => 1,
]);
$ticket  = Freshdesk::tickets()->view($ticketId);
$tickets = Freshdesk::tickets()->all(['updated_since' => '2026-01-01']);

// Conversations
$note = Freshdesk::conversations()->note($ticketId, ['body' => 'Internal note']);

// Contacts, agents, companies, groups
$contact = Freshdesk::contacts()->update($contactId, $data);
$me      = Freshdesk::agents()->current();
$company = Freshdesk::companies()->create($data);
Freshdesk::groups()->delete($groupId);

// Time entries
$entries = Freshdesk::timeEntries()->all($ticketId);

// Forums (discussions)
$category = Freshdesk::discussions()->create($data);
$forum    = Freshdesk::forums()->create($categoryId, $data);
$comment  = Freshdesk::comments()->create($topicId, ['body' => 'Thanks!']);
Freshdesk::topics()->monitor($topicId, $userId);

// Knowledge base (solutions)
$categories = Freshdesk::solutions()->all();
$folder     = Freshdesk::folders()->create($categoryId, $data);
$article    = Freshdesk::articles()->create($folderId, $data);

// Admin
$configs  = Freshdesk::emailConfigs()->all();
$product  = Freshdesk::products()->view($productId);
$hours    = Freshdesk::businessHours()->all();
$policies = Freshdesk::slaPolicies()->all();
```

You can also inject the client instead of using the facade:

```php
use Keepcloud\Laravel\Freshdesk\Api;

public function __construct(private Api $freshdesk) {}
```

### Filtering and pagination

All `GET` requests accept an optional `array $query` parameter:

```php
$page2 = Freshdesk::forums()->all(['page' => 2, 'per_page' => 50]);
```

Response headers of the last request (rate limit, `Link` for pagination):

```php
$headers   = Freshdesk::lastResponseHeaders();
$remaining = $headers['X-RateLimit-Remaining'][0] ?? null;
```

### Error handling

Every failure (HTTP or network) throws `Freshdesk\Exceptions\ApiException`
or one of its subclasses (`ValidationException`, `NotFoundException`,
`AuthenticationException`, `RateLimitExceededException`...):

```php
use Freshdesk\Exceptions\ApiException;
use Freshdesk\Exceptions\RateLimitExceededException;

try {
    Freshdesk::tickets()->create($data);
} catch (RateLimitExceededException $e) {
    $retryAfter = $e->getResponse()?->getHeaderLine('Retry-After');
} catch (ApiException $e) {
    $status = $e->getStatusCode();
    $errors = $e->getErrors(); // Freshdesk validation errors
}
```

## Upgrading from 1.x

- Requires Laravel 12+ and PHP 8.2+.
- Remove the provider and alias from `config/app.php` (auto-discovery handles them).
- Move your credentials to `.env` (`FRESHDESK_API_KEY`, `FRESHDESK_DOMAIN`).
- The SDK 2.0 returns the decoded response directly; drop any use of `->results`.
- `categories()` is deprecated in favour of `discussions()`.

See [CHANGELOG.md](CHANGELOG.md) and the
[SDK changelog](https://github.com/edisoncosta/freshdesk-php-sdk/blob/master/CHANGELOG.md).

## Testing

```sh
composer test
```

## Author

Maintained by [Edison Costa](https://keepcloud.io/) (edison@keepcloud.io).
Originally created by [Matthew Clarkson](http://mpclarkson.github.io/).

## References

* [Freshdesk PHP SDK](https://github.com/edisoncosta/freshdesk-php-sdk)
* [Freshdesk API documentation](https://developers.freshdesk.com/api/)
