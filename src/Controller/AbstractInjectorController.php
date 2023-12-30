<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Controller;

use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractController;
use Laminas\Mvc\Exception\DomainException;
use Laminas\Mvc\Injector\ControllerEvent;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\ResponseInterface;

use function in_array;
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

        $controllerEvent = new ControllerEvent();
        $controllerEvent->setName(ControllerEvent::EVENT_ARGUMENT_RESOLVE);
        $controllerEvent->setRouteMatch($routeMatch);
        $controllerEvent->setRequest($this->request);
        $controllerEvent->setTarget($this);

        $eventManager = $e->getApplication()->getEventManager();

        $actionResponse = $eventManager->triggerEventUntil(
            static fn($test): bool => $test instanceof ResponseInterface,
            $controllerEvent
        );

        $e->setResult($actionResponse->last());

        return $actionResponse->last();
    }

    private function filterParams(array $params): array
    {
        $routeParams = [];

        foreach ($params as $key => $value) {
            if (! in_array($key, ['controller', 'action', '_route'])) {
                $routeParams[$key] = $value;
            }
        }

        return $routeParams;
    }

    private function resolveMethodsInContextOf(string $method, array $params): Response
    {
        return $this->$method();
    }

    /**
     * @param string $action
     */
    public static function getMethodFromAction($action): string
    {
        $method = str_replace(['.', '-', '_'], ' ', $action);
        $method = ucwords($method);
        $method = str_replace(' ', '', $method);

        return lcfirst($method);
    }
}
