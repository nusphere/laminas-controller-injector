<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Resolver;

use Laminas\Mvc\Injector\ControllerEvent;
use ReflectionParameter;

interface ArgumentResolverInterface
{
    public function supports(ReflectionParameter $parameter): bool;

    public function resolve(ReflectionParameter $parameter, ControllerEvent $controllerEvent): mixed;
}
