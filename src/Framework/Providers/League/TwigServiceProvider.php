<?php

namespace Leonidas\Framework\Providers\League;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [Environment::class]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Environment::class, function () use ($container) {
            $config = $container->get('config')->get('twig', []);

            $loader = new FilesystemLoader(
                $config['templates'] ?? null,
                $config['root'] ?? null
            );

            return new Environment($loader, $config['options'] ?? null);
        })->addTag('twig')->addTag('view');
    }
}
