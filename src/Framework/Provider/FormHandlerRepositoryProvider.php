<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Library\Core\Http\Form\FormHandlerRepository;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class FormHandlerRepositoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): FormHandlerRepository
    {
        return new FormHandlerRepository();
    }
}
