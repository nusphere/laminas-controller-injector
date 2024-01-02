<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Factory;

use Laminas\Mvc\Injector\Listener\ArgumentResolverListener;
use Laminas\Mvc\Injector\Resolver\ResolverCollection;
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
        return new ArgumentResolverListener(
            $container->get('ControllerManager'),
            $container->get(ResolverCollection::class)
        );
    }
}
