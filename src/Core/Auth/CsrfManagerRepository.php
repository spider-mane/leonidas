<?php

namespace WebTheory\Leonidas\Core\Auth;

use WebTheory\Leonidas\Core\Contracts\CsrfManagerInterface;

class CsrfManagerRepository
{
    /**
     * @var CsrfManagerInterface[]
     */
    protected $managers;

    /**
     *
     */
    public function __construct(CsrfManagerInterface ...$managers)
    {
        array_walk($managers, [$this, 'addManager']);
    }

    /**
     * Get the value of managers
     *
     * @return CsrfManagerInterface[]
     */
    public function getManagers(): array
    {
        return $this->managers;
    }

    /**
     *
     */
    public function getManager(string $name): ?CsrfManagerInterface
    {
        return $this->managers[$name] ?? null;
    }

    /**
     *
     */
    public function addManager(CsrfManagerInterface $manager)
    {
        $this->managers[$manager->getTag()] = $manager;

        return $this;
    }
}
