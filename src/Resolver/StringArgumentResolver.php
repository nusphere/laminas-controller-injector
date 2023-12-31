<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Resolver;

use Laminas\Mvc\Injector\ControllerEvent;
use ReflectionParameter;

final class StringArgumentResolver implements ArgumentResolverInterface, NonTypeArgumentResolverInterface
{
    public function supports(ReflectionParameter $parameter): bool
    {
        if (! $parameter->hasType()) {
            return true;
        }

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
