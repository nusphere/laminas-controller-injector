<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Factory;

use Laminas\Mvc\Injector\Resolver\ServiceArgumentResolver;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ServiceArgumentResolverFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): ServiceArgumentResolver {
        return new ServiceArgumentResolver($container);
    }
}
