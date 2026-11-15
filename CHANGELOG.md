# Changelog

## [2.0.0] — 2026-11-15

### Breaking changes

- Requires PHP 8.2+ and Laravel 12 or 13 (dropped Laravel 7/8 and Lumen).
  Laravel 10 and 11 are not supported: every release has unpatched security
  advisories and Composer refuses to install them.
- Requires `keepcloud/freshdesk-php-sdk` ^2.0: resource methods now return the
  decoded JSON array (or `null`) instead of the SDK instance.
- Config file moved to `config/freshdesk.php` and now reads `FRESHDESK_API_KEY`
  and `FRESHDESK_DOMAIN` from the environment. Publish it with
  `php artisan vendor:publish --tag=freshdesk-config`.
- Removed `FreshdeskFacade::VERSION`.

### Added

- Package auto-discovery for the service provider and the `Freshdesk` facade.
- `http` config key (timeout, connect_timeout and any Guzzle option) passed to the SDK client.
- `discussions()`, `solutions()`, `folders()` and `articles()` resources.
- `lastResponseHeaders()` and `sdk()` accessors.
- Native return types and `@method` facade docblocks for IDE autocompletion.
- PHPUnit + Testbench test suite and GitHub Actions CI.
- `.mailmap` mapping old commit e-mails to edison@keepcloud.io.

### Fixed

- `categories()` pointed to a property that does not exist in the SDK; it now
  returns the discussions resource (deprecated alias of `discussions()`).
- Config is merged in `register()`, so it is available before the client is resolved.
- README examples (`tickets()->view()`, `comments()->create()`, config path, badge).
