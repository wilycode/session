<?php

declare(strict_types=1);

namespace WilyCode\Session\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use WilyCode\Session\SessionInterface;

final class SessionInterfaceTest extends TestCase
{
    public function test_session_interface_is_storage_agnostic_contract(): void
    {
        $reflection = new ReflectionClass(SessionInterface::class);

        self::assertTrue($reflection->isInterface());
        self::assertSame([], $reflection->getInterfaceNames());
    }

    public function test_session_interface_has_expected_methods(): void
    {
        $reflection = new ReflectionClass(SessionInterface::class);
        $methods = array_map(
            static fn (ReflectionMethod $method): string => $method->getName(),
            $reflection->getMethods(),
        );

        self::assertSame([
            'withNamespace',
            'getNamespace',
            'set',
            'get',
            'has',
            'remove',
            'all',
            'replace',
            'clear',
        ], $methods);
    }

    public function test_namespace_methods_have_expected_signatures(): void
    {
        self::assertSame(['string'], $this->parameterTypes('withNamespace'));
        self::assertSame('static', $this->returnType('withNamespace'));
        self::assertSame([], $this->parameterTypes('getNamespace'));
        self::assertSame('string', $this->returnType('getNamespace'));
    }

    public function test_key_value_methods_have_expected_signatures(): void
    {
        self::assertSame(['string', 'mixed'], $this->parameterTypes('set'));
        self::assertSame('void', $this->returnType('set'));

        self::assertSame(['string', 'mixed'], $this->parameterTypes('get'));
        self::assertSame('mixed', $this->returnType('get'));
        $default = (new ReflectionMethod(SessionInterface::class, 'get'))->getParameters()[1];
        self::assertTrue($default->isDefaultValueAvailable());
        self::assertNull($default->getDefaultValue());

        self::assertSame(['string'], $this->parameterTypes('has'));
        self::assertSame('bool', $this->returnType('has'));
        self::assertSame(['string'], $this->parameterTypes('remove'));
        self::assertSame('void', $this->returnType('remove'));

        self::assertSame([], $this->parameterTypes('all'));
        self::assertSame('array', $this->returnType('all'));
        self::assertSame(['array'], $this->parameterTypes('replace'));
        self::assertSame('void', $this->returnType('replace'));
        self::assertSame([], $this->parameterTypes('clear'));
        self::assertSame('void', $this->returnType('clear'));
    }

    /** @return list<string> */
    private function parameterTypes(string $method): array
    {
        $reflection = new ReflectionMethod(SessionInterface::class, $method);

        return array_map(
            static fn ($parameter): string => (string) $parameter->getType(),
            $reflection->getParameters(),
        );
    }

    private function returnType(string $method): string
    {
        return (string) (new ReflectionMethod(SessionInterface::class, $method))->getReturnType();
    }
}
