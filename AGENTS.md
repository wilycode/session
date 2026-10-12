# WilyCode Session — Maintainer Notes

## Scope

This repository contains only the storage-agnostic `WilyCode\Session\SessionInterface` contract.

## Guidelines

- Keep the interface independent of native PHP sessions, databases, and caches.
- Keep concrete adapters in separate repositories (for example, `wilycode/session-php`).
- Do not add runtime dependencies without an explicit reason.
- Keep the public API small and typed; breaking signature changes require a major version.
- When changing the contract, update tests, README, and CHANGELOG.
- Use PSR-12 style, four-space indentation, and `declare(strict_types=1);`.
