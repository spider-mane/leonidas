<?php

namespace Leonidas\Framework\Providers\League;

use Http\Factory\Guzzle\ResponseFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Http\Message\ResponseFactoryInterface;

class GuzzleResponseFactoryServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [ResponseFactoryInterface::class]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(ResponseFactoryInterface::class, function () {
            return new ResponseFactory();
        });
    }
}
