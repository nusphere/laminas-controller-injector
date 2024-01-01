<?php

declare(strict_types=1);

use Laminas\Mvc\Injector\Factory\ArgumentResolverListenerFactory;
use Laminas\Mvc\Injector\Factory\ServiceArgumentResolverFactory;
use Laminas\Mvc\Injector\Listener\ArgumentResolverListener;
use Laminas\Mvc\Injector\Resolver\IntegerArgumentResolver;
use Laminas\Mvc\Injector\Resolver\RequestArgumentResolver;
use Laminas\Mvc\Injector\Resolver\ServiceArgumentResolver;
use Laminas\Mvc\Injector\Resolver\StringArgumentResolver;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'listeners'       => [
        ArgumentResolverListener::class,
    ],
    'service_manager' => [
        'factories' => [
            ArgumentResolverListener::class => ArgumentResolverListenerFactory::class,
            IntegerArgumentResolver::class  => InvokableFactory::class,
            RequestArgumentResolver::class  => InvokableFactory::class,
            StringArgumentResolver::class   => InvokableFactory::class,
            ServiceArgumentResolver::class  => ServiceArgumentResolverFactory::class,
        ],
    ],
];
