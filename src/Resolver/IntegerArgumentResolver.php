<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Resolver;

use Laminas\Mvc\Injector\ControllerEvent;
use ReflectionParameter;

final class IntegerArgumentResolver implements ArgumentResolverInterface
{
    public function supports(ReflectionParameter $parameter): bool
    {
        if (! $parameter->hasType()) {
            return false;
        }

        return $parameter->getType()->getName() === 'int';
    }

    public function resolve(ReflectionParameter $parameter, ControllerEvent $controllerEvent): int
    {
        $default = null;

        if ($parameter->isDefaultValueAvailable()) {
            $default = $parameter->getDefaultValue();
        }

        $routeParam = $controllerEvent->getRouteMatch()->getParam($parameter->getName());

        return (int) ($routeParam ?? $default);
    }
}
