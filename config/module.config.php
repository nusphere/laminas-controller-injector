<?php

declare(strict_types=1);

use Laminas\Mvc\Injector\Factory\ArgumentResolverListenerFactory;
use Laminas\Mvc\Injector\Factory\ResolverCollectionFactory;
use Laminas\Mvc\Injector\Factory\ServiceArgumentResolverFactory;
use Laminas\Mvc\Injector\Listener\ArgumentResolverListener;
use Laminas\Mvc\Injector\Resolver\IntegerArgumentResolver;
use Laminas\Mvc\Injector\Resolver\RequestArgumentResolver;
use Laminas\Mvc\Injector\Resolver\ResolverCollection;
use Laminas\Mvc\Injector\Resolver\ServiceArgumentResolver;
use Laminas\Mvc\Injector\Resolver\StringArgumentResolver;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    /**
     * each resolver need to implement ArgumentResolverInterface:class
     */
    'controller_argument_resolver' => [
        StringArgumentResolver::class,
        IntegerArgumentResolver::class,
        RequestArgumentResolver::class,
        ServiceArgumentResolver::class,
    ],
    'listeners'                    => [
        ArgumentResolverListener::class,
    ],
    'service_manager'              => [
        'factories' => [
            ArgumentResolverListener::class => ArgumentResolverListenerFactory::class,
            IntegerArgumentResolver::class  => InvokableFactory::class,
            RequestArgumentResolver::class  => InvokableFactory::class,
            StringArgumentResolver::class   => InvokableFactory::class,
            ServiceArgumentResolver::class  => ServiceArgumentResolverFactory::class,
            ResolverCollection::class       => ResolverCollectionFactory::class,
        ],
    ],
];
