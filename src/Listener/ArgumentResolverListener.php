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
use Laminas\Mvc\Injector\Resolver\NonTypeArgumentResolverInterface;
use Laminas\Mvc\Injector\Resolver\ResolverCollection;
use ReflectionClass;
use ReflectionException;

use function call_user_func;

final class ArgumentResolverListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function __construct(
        private readonly ControllerManager $controllerManager,
        private readonly ResolverCollection $argumentResolver
    ) {
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    private function onArgumentResolverEvent(ControllerEvent $event): Response
    {
        $routeMatch = $event->getRouteMatch();

        $controller = $this->controllerManager->get($routeMatch->getParam('controller'));
        $action     = $routeMatch->getParam('action');

        $controllerReflection = new ReflectionClass($controller);
        $method               = $controllerReflection->getMethod($action);

        $arguments = [];
        foreach ($method->getParameters() as $parameter) {
            foreach ($this->argumentResolver->getResolvers() as $resolver) {
                if ($parameter->hasType() || $resolver instanceof NonTypeArgumentResolverInterface) {
                    if ($resolver->supports($parameter)) {
                        $arguments[$parameter->getPosition()] = $resolver->resolve($parameter, $event);

                        continue 2;
                    }
                }
            }

            throw new Exception(
                'unable to solve argument ' . $parameter->getName() . ' ' . $parameter->getType()->getName()
            );
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
