# WilyCode Session

[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4%2B-777BB4)](https://www.php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Tests](https://github.com/wilycode/session/actions/workflows/tests.yml/badge.svg)](https://github.com/wilycode/session/actions/workflows/tests.yml)

**A small, storage-agnostic session contract for PHP 8.4+.**

Define how application code accesses session data without tying it to PHP's native sessions, a database, or another storage backend. This package contains **an interface only**; it does not start sessions or persist values.

> **WilyCode PHP Ecosystem**
>
> Part of **[WilyCode](https://github.com/wilycode/wilycode)** — independent, reusable PHP components with their own repositories, releases, and Composer packages.
>
> **[Explore the WilyCode ecosystem →](https://github.com/wilycode/wilycode)**

## Features

- A single, minimal `SessionInterface` contract.
- Namespace-scoped key/value access for independent application modules.
- Read, write, check, remove, replace, list, and clear session values.
- No dependencies on native PHP sessions or any storage system.
- Compatible with custom storage adapters that implement the interface.

## Requirements

- PHP 8.4 or newer.
- No runtime Composer dependencies.

## Installation

```bash
composer require wilycode/session
```

This installs **only the contract**. To use persistent session storage, install an implementation such as [`wilycode/session-php`](https://github.com/wilycode/session-php) and follow that adapter's setup instructions, or implement `SessionInterface` yourself.

## Quick start

Type-hint `SessionInterface` in application services. The `$session` instance must be supplied by an adapter; it is not created by this package.

```php
<?php

declare(strict_types=1);

use WilyCode\Session\SessionInterface;

function rememberAuthenticatedUser(SessionInterface $session, int $userId): void
{
    $auth = $session->withNamespace('auth');
    $auth->set('user_id', $userId);
}

function currentUserId(SessionInterface $session): ?int
{
    $auth = $session->withNamespace('auth');
    $userId = $auth->get('user_id');

    return is_int($userId) ? $userId : null;
}
```

The `auth` namespace keeps authentication keys separate from keys used by other modules.

## Working with namespaces

The contract exposes a session view scoped to a named *bag*:

```php
$auth = $session->withNamespace('auth');
$preferences = $session->withNamespace('preferences');

$auth->set('user_id', 123);
$preferences->set('theme', 'dark');

$auth->getNamespace();        // 'auth'
$preferences->getNamespace(); // 'preferences'

$auth->get('user_id');         // 123
$preferences->get('theme');    // 'dark'
```

An empty namespace (`''`) denotes the root bag. Exactly how namespace views are represented internally is up to the adapter.

## Session operations

All operations act on the **current namespace**, not on every bag in the session.

```php
$bag = $session->withNamespace('cart');

$bag->set('currency', 'EUR');
$currency = $bag->get('currency', 'USD');

$exists = $bag->has('currency');
$values = $bag->all();

$bag->remove('currency');
$bag->replace(['currency' => 'USD', 'items' => []]);
$bag->clear();
```

| Method | Purpose |
| --- | --- |
| `withNamespace(string $namespace): static` | Obtain a session view scoped to a bag. |
| `getNamespace(): string` | Get the current bag name (`''` means root). |
| `set(string $key, mixed $value): void` | Set a value in the current bag. |
| `get(string $key, mixed $default = null): mixed` | Read a value or return the supplied default. |
| `has(string $key): bool` | Check whether a key exists. |
| `remove(string $key): void` | Remove a key. |
| `all(): array` | Get all key/value pairs in the current bag. |
| `replace(array $values): void` | Replace all values in the current bag. |
| `clear(): void` | Clear the current bag only. |

> **Contract boundaries:** This interface does not define session startup, ID rotation, cookie policies, expiration, or serialization. Those concerns belong to the concrete adapter and application. Do not assume all adapters share the same lifecycle or storage guarantees.

## Related packages

| Package | Purpose |
| --- | --- |
| [`wilycode/session-php`](https://github.com/wilycode/session-php) | Native PHP session adapter implementing this contract. |

## Development

```bash
composer install
composer validate --strict
composer test
```

Tests run in [GitHub Actions](https://github.com/wilycode/session/actions) on pushes and pull requests. Development-only files remain in Git but are excluded from Composer distribution archives.

## Contributing

Issues and pull requests are welcome. See [CONTRIBUTING.md](CONTRIBUTING.md) and the [issue tracker](https://github.com/wilycode/session/issues).

## License

MIT © 2026 Simon Piter. See [LICENSE](LICENSE).
