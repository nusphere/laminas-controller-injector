<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Controller;

use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractController;
use Laminas\Mvc\Exception\DomainException;
use Laminas\Mvc\MvcEvent;

use function lcfirst;
use function method_exists;
use function str_replace;
use function ucwords;

class AbstractInjectorController extends AbstractController
{
    public function onDispatch(MvcEvent $e): Response
    {
        $routeMatch = $e->getRouteMatch();
        if (! $routeMatch) {
            /**
             * @todo Determine requirements for when route match is missing.
             *       Potentially allow pulling directly from request metadata?
             */
            throw new DomainException('Missing route matches; unsure how to retrieve action');
        }

        $action = $routeMatch->getParam('action', 'not-found');
        $method = static::getMethodFromAction($action);

        if (! method_exists($this, $method)) {
            $method = 'notFoundAction';
        }

        $actionResponse = $this->$method();

        $e->setResult($actionResponse);

        return $actionResponse;
    }

    public static function getMethodFromAction($action): string
    {
        $method = str_replace(['.', '-', '_'], ' ', $action);
        $method = ucwords($method);
        $method = str_replace(' ', '', $method);

        return lcfirst($method);
    }
}
