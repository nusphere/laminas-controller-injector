<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Functional\Test\Demo\Service;

final class DemoService
{
    public function getValue(): int
    {
        return 12;
    }
}
