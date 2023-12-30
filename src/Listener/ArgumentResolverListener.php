<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Listener;

use Exception;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\Mvc\Injector\ControllerEvent;
use ReflectionClass;

use function call_user_func;

final class ArgumentResolverListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function __construct(private ControllerManager $controllerManager)
    {
    }

    private function onArgumentResolverEvent(ControllerEvent $event): Response
    {
        $routeMatch = $event->getRouteMatch();

        $controller = $this->controllerManager->get($routeMatch->getParam('controller'));
        $action     = $routeMatch->getParam('action');

        $controllerReflection = new ReflectionClass($controller);
        $method               = $controllerReflection->getMethod($action);

        $arguments = [];
        foreach ($method->getParameters() as $parameter) {
            foreach ($event->getResolver() as $resolver) {
                if ($resolver->supports($parameter)) {
                    $arguments[$parameter->getPosition()] = $resolver->resolve($parameter, $event);

                    continue 2;
                }
            }

            throw new Exception('unable to solve argument ' . $parameter->getName() . ' ' . $parameter->getType()->getName());
        }

        return call_user_func([$controller, $action], ...$arguments);
    }

    /**
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $events->attach(
            ControllerEvent::EVENT_ARGUMENT_RESOLVE,
            fn (ControllerEvent $event) => self::onArgumentResolverEvent($event),
            $priority
        );
    }
}