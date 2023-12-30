<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Resolver;

use Laminas\Mvc\Injector\ControllerEvent;
use ReflectionParameter;

final class StringArgumentResolver implements ArgumentResolverInterface
{
    public function supports(ReflectionParameter $parameter): bool
    {
        return $parameter->getType()->getName() === 'string';
    }

    public function resolve(ReflectionParameter $parameter, ControllerEvent $controllerEvent): string
    {
        $default = null;

        if ($parameter->isDefaultValueAvailable()) {
            $default = $parameter->getDefaultValue();
        }

        $routeParam = $controllerEvent->getRouteMatch()->getParam($parameter->getName());

        return (string) ($routeParam ?? $default);
    }
}
