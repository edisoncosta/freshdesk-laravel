# Freshdesk Service Provider for Laravel 6

[![Packagist](https://img.shields.io/badge/Packagist-freshdesk--laravel-blue)](https://packagist.org/packages/keepcloud/freshdesk-php-sdk)

This is a service provider for interacting with the Freshdesk API v2 via the 
[freshdesk-php-sdk](https://github.com/keepcloud/freshdesk-php-sdk) in Laravel and Lumen applications.

## Installation

To add this bundle to your app, use [Composer](https://getcomposer.org).

Add `keepcloud/freshdesk-laravel` to your **composer.json** file:

```json
{
    "require": {
        "keepcloud/freshdesk-laravel": "^1.0"
    }
}
```

Then run:
 
 ```sh
 composer update
 ```

You must then register the provider in your application.

Register the provider in the `providers` key in your `config/app.php`:

```php
    'providers' => array(
        // ...
        Keepcloud\Laravel\Freshdesk\FreshdeskServiceProvider::class,
    )
```

Then add the Freshdesk facade alias in the `aliases` key in your `config/app.php`:

```php
    'aliases' => array(
        // ...
        'Freshdesk' => Keepcloud\Laravel\Freshdesk\FreshdeskFacade::class,
    )
```

## Configuration


To customize the configuration file, publish the package configuration using Artisan.

```sh
php artisan vendor:publish
```

Update the settings in the `app/config/freshdesk.php` file.

```php
return [
    'api_key' => 'your_freshdesk_api_key',
    'domain' => 'your_freshdesk_domain',
];
```


## Accessing the Freshdesk API

In a controller you can access Freshdesk resource
as follows: 

```php

//Contacts
$contacts = Freshdesk::contacts()->update($contactId, $data);

//Agents
$me = Freshdesk::agents()->current();

//Companies
$company = Freshdesk::companies()->create($data);

//Groups
$deleted = Freshdesk::groups()->delete($groupId);

//Tickets
$ticket = Freshdesk::tickets()->view($filters);

//Time Entries
$time = Freshdesk::timeEntries()->all($ticket['id']);

//Conversations
$ticket = Freshdesk::conversations()->note($ticketId, $data);

//Categories
$newCategory = Freshdesk::categories()->create($data);

//Forums
$forum = Freshdesk::forums()->create($categoryId, $data);

//Topics
$topics =Freshdesk::topics()->monitor($topicId, $userId);

//Comments
$comment = Freshdesk::comments()->create($forumId);

//Email Configs
$configs = Freshdesk::emailConfigs()->all();

//Products
$product = Freshdesk::products()->view($productId);

//Business Hours
$hours = Freshdesk::businessHours()->all();

//SLA Policy
$policies = Freshdesk::slaPolicies()->all();
```

### Filtering

All `GET` requests accept an optional `array $query` parameter to filter
results. For example:

```php
//Page 2 with 50 results per page
$page2 = Freshdesk::forums()->all(['page' => 2, 'per_page' => 50]);

//Tickets for a specific customer
$tickets = Freshdesk::tickets()->view(['company_id' => $companyId]);
```

Please read the Freshdesk documentation for further information on
filtering `GET` requests.

## Contributing

This is a work in progress and PRs are welcome. Please read the 
[contributing guide](.github/CONTRIBUTING.md).

## Author

The library was written and maintained by [Edison Costa](https://keepcloud.io/) 

## References

* [Freshdesk PHP SDK](https://github.com/keepcloud/freshdesk-php-sdk)
* [Freshdesk API Documentation](https://developer.freshdesk.com/api/)
