<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\Core\Http\Form\FormRepository;
use Psr\Container\ContainerInterface;

class FormRepositoryProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): FormRepository
    {
        return new FormRepository();
    }
}
