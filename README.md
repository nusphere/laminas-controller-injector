# Laminas Controller Injector

## Description

The core feature of this “plugin” is the ability to set parameters for controller methods.
Primarily to pass the value of a variable of a route directly to the method at the dispatch event as an argument. 
The new `AbstractInjectorController` must be used for this usage.

In addition, with the new dispatcher you can also do without the “Action” postfix for these methods.

## Requirements

- PHP 8.1 or above
- Laminas MVC 3.7.0 or above

## Installation

Use composer to install the package:

`composer require nubox/laminas-controller-injector`

## Usage

Suppose you have a controller that looks like this:

```php
class MyController extends AbstractInjectorController
{ 
    public function myMethod(string $param) { 
        // ... 
    } 
}
```

You can map routes to this controller method using the format `controller::method` and
pass parameters from the routes directly into the method:

```php
return [
    'router' => [
        'routes' => [
            'my-route' => [
                'type' => Laminas\Router\Http\Segment::class,
                'options' => [
                    'route' => '/my-route/:param',
                    'defaults' => [
                        'controller' => MyController::class,
                        'action' => 'myMethod'
                    ]
                ]
            ]
        ]
    ],
];
```

In the example above, the `:param` placeholder in the route gets passed directly as the `$param` argument
to `myMethod()`.

## AbstractInjectorController

The provided `\Laminas\Mvc\Injector\Controller\AbstractInjectorController` is required as Controller extension.
It matches the given parameter values into the requested action. The same variable name is required.

As soon as the `AbstractInjectorController` is used, in addition to the route parameters, objects from the 
`ServiceManager` are also injected into the corresponding controller method  - regardless of the route.
This reduces the processes necessary to access a service from the ServiceManager.

The respective request can also be injected as a complete request object.

```php
class MyController extends AbstractInjectorController
{
    public function serviceParameter(DemoService $demoService): Response
    {
        $response = new Response();
        $response->setContent($demoService->getValue());

        return $response;
    }
}
```

## Available ArgumentResolver -> (configurable `controller_argument_resolver`)

Every argument of a controller method is analyzed and can be determined by the activated ArgumentResolver. 
The following ArgumentResolvers are activated by default. However, additional ArgumentResolvers can also be added.

#### Activated by default:
* IntegerArgumentResolver - inject a `int`, parsed from Route parameters (`int` required)
* StringArgumentResolver - inject a `string` , parsed from Route parameters (no typehint or `string` required)
* RequestArgumentResolver - inject the responding `Request` object into the method (`Request` required)
* ServiceArgumentResolver - inject an `object` from the container (ServiceManager) (explicit object Typehint required)

```php
return [
    /**
     * each resolver need to implement ArgumentResolverInterface:class
     */
    'controller_argument_resolver' => [
        StringArgumentResolver::class,
        IntegerArgumentResolver::class,
        RequestArgumentResolver::class,
        ServiceArgumentResolver::class,
    ],
];
```

Normally you need a corresponding type hint to determine the correct ArgumentResolver.
In the event that no suitable type can be found, you can use the MarkUp interface `NonTypeArgumentResolverInterface` 
for your own ArgumentResolver. this would then also be “queried” in such a case.

## Suggestion

Use [nubox/laminas-router-attributes](https://github.com/nusphere/laminas-router-attributes) for reduce configuration
overhead with symfony route attributes.

```php
class MyController extends AbstractInjectorController
{ 
    #[Route(path: 'calc-optional/{operand1}/{operand2?100}', name: 'calc-optional-route')]
    public function calculateWithRouteDefault(int $operand1, int $operand2 = 100): Response
    {
        $response = new Response();
        $response->setContent($operand1 * $operand2);

        return $response;
    }
    
    #[Route(path: 'default', name: 'default-route')]
    public function somedefaults(Request $request, string $default = 'defaults'): Response
    {
        $response = new Response();
        $response->setContent($request->getUri()->getPath() . ' - ' . $default);

        return $response;
    }
}
```
