<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Functional\Test\Demo\Controller;

use Laminas\Http\Response;
use Laminas\Mvc\Injector\Controller\AbstractInjectorController;
use Symfony\Component\Routing\Attribute\Route;

final class DemoController extends AbstractInjectorController
{
    #[Route(path: 'demo', name: 'demo-route')]
    public function demo(): Response
    {
        $response = new Response();
        $response->setContent('<b>This is a demo controller</b>');

        return $response;
    }
}
