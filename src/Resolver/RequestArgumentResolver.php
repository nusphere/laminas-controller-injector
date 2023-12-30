<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Resolver;

use Laminas\Http\Request;
use Laminas\Mvc\Injector\ControllerEvent;
use ReflectionParameter;

final class RequestArgumentResolver implements ArgumentResolverInterface
{
    public function supports(ReflectionParameter $parameter): bool
    {
        if (! $parameter->hasType()) {
            return false;
        }

        return $parameter->getType()->getName() === Request::class;
    }

    public function resolve(ReflectionParameter $parameter, ControllerEvent $controllerEvent): Request
    {
        return $controllerEvent->getRequest();
    }
}
