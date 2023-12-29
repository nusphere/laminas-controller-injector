<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Unit\Test;

use Laminas\Mvc\Injector\Module;
use PHPUnit\Framework\TestCase;

final class ModuleTest extends TestCase
{
    public function testModuleConfig(): void
    {
        $module = new Module();

        $this->assertIsArray($module->getConfig());
    }
}
