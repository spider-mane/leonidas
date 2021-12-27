<?php

namespace Leonidas\Framework\Providers\League;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Leonidas\Framework\App\Forms\FormRepository;

class FormRepositoryServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [FormRepository::class]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(FormRepository::class, function () {
            return new FormRepository();
        });
    }
}
