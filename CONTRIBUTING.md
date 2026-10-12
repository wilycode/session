# Contributing to WilyCode Session

Thanks for your interest in contributing.

## Getting started

1. Fork the repository and create a focused branch.
2. Install dependencies with `composer install` (PHP 8.4+).
3. Run `composer validate --strict` and `composer test`.
4. Open a pull request describing the change and any API implications.

## Scope

This package is an interface-only, storage-agnostic contract. Keep native PHP session storage, persistence, cookie handling, and other adapter-specific behavior out of this repository. Implementations belong in separate packages, such as `wilycode/session-php`.

Public signature changes affect every adapter; discuss them in an issue before submitting a breaking change. When editing the contract, update the tests, README, and CHANGELOG.

Please do not commit secrets, generated `vendor/` content, or local test caches.
