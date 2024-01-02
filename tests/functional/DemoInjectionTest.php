<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Functional\Test;

use Laminas\Test\PHPUnit\Controller\AbstractControllerTestCase;

use function dirname;

final class DemoInjectionTest extends AbstractControllerTestCase
{
    protected function setUp(): void
    {
        $this->setApplicationConfig(include dirname(__DIR__, 2) . '/config/test/application.config.php');
    }

    public function testSimpleDemo(): void
    {
        $this->dispatch('/demo');

        self::assertSame('<b>This is a demo controller</b>', $this->getResponse()->getContent());
    }

    public function testStringInjectionDemo(): void
    {
        $this->dispatch('/greet/Bob');

        self::assertSame('<b>Hi Bob</b>', $this->getResponse()->getContent());
    }

    public function testIntegerInjectionDemo(): void
    {
        $this->dispatch('/calc/55/88');

        self::assertSame(55 + 88, $this->getResponse()->getContent());
    }

    public function testIntegerWithDefaultInjectionDemo(): void
    {
        $this->dispatch('/calc-optional/55');

        self::assertSame(5500, $this->getResponse()->getContent());
    }

    public function testRequestInjectionDemo(): void
    {
        $this->dispatch('/request-uri');

        self::assertSame('/request-uri', $this->getResponse()->getContent());
    }

    public function testRequestWithDefaultsInjectionDemo(): void
    {
        $this->dispatch('/default');

        self::assertSame('/default - defaults', $this->getResponse()->getContent());
    }

    public function testNoTypehintInjectionDemo(): void
    {
        $this->dispatch('/no-typehint/variable');

        self::assertSame('/no-typehint/variable - variable', $this->getResponse()->getContent());
    }

    public function testServiceDemo(): void
    {
        $this->dispatch('/service-test');

        self::assertSame(12, $this->getResponse()->getContent());
    }
}
