<?php

declare(strict_types=1);

use Laminas\Mvc\Injector\Factory\ArgumentResolverListenerFactory;
use Laminas\Mvc\Injector\Listener\ArgumentResolverListener;

return [
    'listeners'       => [
        ArgumentResolverListener::class,
    ],
    'service_manager' => [
        'factories' => [
            ArgumentResolverListener::class => ArgumentResolverListenerFactory::class,
        ],
    ],
];
