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
}
