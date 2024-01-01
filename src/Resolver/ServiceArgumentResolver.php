<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Resolver;

use Laminas\Mvc\Injector\ControllerEvent;
use Psr\Container\ContainerInterface;
use ReflectionParameter;

final class ServiceArgumentResolver implements ArgumentResolverInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function supports(ReflectionParameter $parameter): bool
    {
        if (! $parameter->hasType()) {
            return false;
        }

        return $this->container->has($parameter->getType()->getName());
    }

    public function resolve(ReflectionParameter $parameter, ControllerEvent $controllerEvent): mixed
    {
        return $this->container->get($parameter->getType()->getName());
    }
}
