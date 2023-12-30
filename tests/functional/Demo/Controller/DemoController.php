<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Functional\Test\Demo\Controller;

use Laminas\Http\Request;
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

    #[Route(path: 'greet/{name}', name: 'greetings-route')]
    public function greets(string $name): Response
    {
        $response = new Response();
        $response->setContent('<b>Hi ' . $name . '</b>');

        return $response;
    }

    #[Route(path: 'calc/{operand1}/{operand2}', name: 'calc-route')]
    public function calculate(int $operand1, int $operand2): Response
    {
        $response = new Response();
        $response->setContent($operand1 + $operand2);

        return $response;
    }

    #[Route(path: 'calc-optional/{operand1}/{operand2?100}', name: 'calc-optional-route')]
    public function calculateWithRouteDefault(int $operand1, int $operand2 = 100): Response
    {
        $response = new Response();
        $response->setContent($operand1 * $operand2);

        return $response;
    }

    #[Route(path: 'request-uri', name: 'request-route')]
    public function some(Request $request): Response
    {
        $response = new Response();
        $response->setContent($request->getUri()->getPath());

        return $response;
    }

    #[Route(path: 'default', name: 'default-route')]
    public function somedefaults(Request $request, string $default = 'defaults'): Response
    {
        $response = new Response();
        $response->setContent($request->getUri()->getPath() . ' - ' . $default);

        return $response;
    }

    #[Route(path: 'no-typehint/{var}', name: 'typehint-route')]
    public function noTypeHintParamter(Request $request, $var): Response
    {
        $response = new Response();
        $response->setContent($request->getUri()->getPath() . ' - ' . $var);

        return $response;
    }
}
