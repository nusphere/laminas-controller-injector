<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector;

use Laminas\EventManager\Event;
use Laminas\Http\Request;
use Laminas\Mvc\Exception\DomainException;
use Laminas\Router\RouteMatch;

final class ControllerEvent extends Event
{
    private ?RouteMatch $routeMatch;

    private object $controller;

    private Request $request;

    public const EVENT_ARGUMENT_RESOLVE = 'argument_resolve';

    public function setRouteMatch(RouteMatch $routeMatch): void
    {
        $this->routeMatch = $routeMatch;
    }

    public function getRouteMatch(): RouteMatch
    {
        if (! $this->routeMatch instanceof RouteMatch) {
            throw new DomainException('Missing route matches; unsure how to retrieve event');
        }

        return $this->routeMatch;
    }

    public function getController(): object
    {
        return $this->controller;
    }

    public function setController(object $controller): void
    {
        $this->controller = $controller;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
