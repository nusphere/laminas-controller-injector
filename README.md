# Laminas Controller Injector

## Description

This package provides a way to use controllers in a Laminas application without the need of naming a method with the "Action" prefix. It also passes route parameters into controller methods as arguments.

## Requirements

- PHP 8.1 or above
- Laminas MVC 3.7.0 or above

## Installation

Use composer to install the package:

`composer require nubox/laminas-controller-injector`

## Usage

Suppose you have a controller that looks like this:

```php
class MyController { 
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

## Suggestion

Use [nubox/laminas-router-attributes](https://github.com/nusphere/laminas-router-attributes) for reduce configuration
overhead with symfony route attributes.
