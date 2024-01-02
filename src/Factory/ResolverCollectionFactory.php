<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Factory;

use Laminas\Mvc\Injector\Resolver\ArgumentResolverInterface;
use Laminas\Mvc\Injector\Resolver\ResolverCollection;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ResolverCollectionFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ResolverCollection
    {
        $resolverObjects = [];

        $resolverConfig = $container->get('config')['controller_argument_resolver'];

        foreach ($resolverConfig as $resolver) {
            if ($container->has($resolver)) {
                $resolverObj = $container->get($resolver);

                if ($resolverObj instanceof ArgumentResolverInterface) {
                    $resolverObjects[] = $container->get($resolver);
                }
            }
        }

        return new ResolverCollection($resolverObjects);
    }
}
