<?php

declare(strict_types=1);

namespace Laminas\Mvc\Injector\Resolver;

class ResolverCollection
{
    /**
     * @param ArgumentResolverInterface[] $resolvers
     */
    public function __construct(
        private readonly array $resolvers
    ) {
    }

    /**
     * @return ArgumentResolverInterface[]
     */
    public function getResolvers(): array
    {
        return $this->resolvers;
    }
}
