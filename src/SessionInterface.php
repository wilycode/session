<?php

declare(strict_types=1);

namespace WilyCode\Session;

/**
 * Minimal session API used by the WilyCode ecosystem.
 *
 * The session is treated as a key/value store scoped to a namespace (bag).
 * Namespaces help avoid key collisions between independent modules.
 */
interface SessionInterface
{
    /**
     * Returns a session view scoped to a namespace/bag.
     *
     * Example:
     *  $auth = $session->withNamespace('auth');
     *  $auth->set('userId', 123);
     */
    public function withNamespace(string $namespace): static;

    /**
     * Returns current namespace/bag name. Empty string means "root".
     */
    public function getNamespace(): string;

    public function set(string $key, mixed $value): void;

    public function get(string $key, mixed $default = null): mixed;

    public function has(string $key): bool;

    public function remove(string $key): void;

    /**
     * Returns all values from the current namespace/bag.
     *
     * @return array<string, mixed>
     */
    public function all(): array;

    /**
     * Replaces all values in the current namespace/bag.
     *
     * @param array<string, mixed> $values
     */
    public function replace(array $values): void;

    /**
     * Clears only the current namespace/bag.
     */
    public function clear(): void;
}
