<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Factory;

use Laminas\Mvc\Injector\ControllerEvent;
use Laminas\Mvc\Injector\Listener\ArgumentResolverListener;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ArgumentResolverListenerFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): ArgumentResolverListener {
        $event = new ControllerEvent();

        $resolverObject = [];

        $resolvers = $event->getResolver();

        foreach ($resolvers as $resolver) {
            $resolverObject[] = $container->get($resolver);
        }

        return new ArgumentResolverListener($container->get('ControllerManager'), $resolverObject);
    }
}
