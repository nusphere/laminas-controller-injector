<?php

declare(strict_types=1);

use Laminas\Mvc\Injector\Functional\Test\Demo\Controller\DemoController;
use Laminas\Mvc\Injector\Functional\Test\Demo\Service\DemoService;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers'     => [
        'factories' => [
            DemoController::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            DemoService::class => InvokableFactory::class,
        ],
    ],
];
