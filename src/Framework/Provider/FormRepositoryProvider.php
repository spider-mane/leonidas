<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Library\Core\Http\Form\FormRepository;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class FormRepositoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): FormRepository
    {
        return new FormRepository();
    }
}
