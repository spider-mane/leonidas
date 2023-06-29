<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Library\System\Configuration\Option\OptionRepository;
use Leonidas\Library\System\Schema\Option\OptionManager;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class OptionRepositoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = [])
    {
        return new OptionRepository(new OptionManager());
    }
}
