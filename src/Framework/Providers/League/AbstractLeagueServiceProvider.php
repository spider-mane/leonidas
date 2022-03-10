<?php

namespace Leonidas\Framework\Providers\League;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Leonidas\Framework\Providers\Traits\ExtensionAwareTrait;
use Psr\Container\ContainerInterface;
use WebTheory\Config\Interfaces\ConfigInterface;

abstract class AbstractLeagueServiceProvider extends AbstractServiceProvider
{
    use ExtensionAwareTrait;

    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [$this->serviceId(), ...$this->serviceTags()]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();
        $definition = $container->add(
            $this->serviceId(),
            fn () => $this->service($container)
        );

        if (null !== $shared = $this->shared()) {
            $definition->setShared($shared);
        }

        if (!empty($alias = $this->serviceAlias())) {
            $definition->setAlias($alias);
        }

        array_map([$definition, 'addTag'], $this->serviceTags());
    }

    protected function config(): ConfigInterface
    {
        return $this->container->get($this->configService);
    }

    protected function shared(): ?bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    protected function serviceTags(): array
    {
        return [];
    }

    protected function serviceAlias(): string
    {
        return '';
    }

    abstract protected function service(ContainerInterface $container);

    abstract protected function serviceId(): string;
}
