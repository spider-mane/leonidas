<?php

namespace WebTheory\Leonidas\Library\Core\Auth;

use WebTheory\Leonidas\Contracts\Auth\CsrfManagerInterface;
use WebTheory\Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;

class CsrfManagerRepository implements CsrfManagerRepositoryInterface
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
    public function getManager(string $tag): ?CsrfManagerInterface
    {
        return $this->managers[$tag] ?? null;
    }

    /**
     *
     */
    public function getManagerSelection(string ...$tags): array
    {
        $managers = [];

        foreach ($tags as $tag) {
            $managers[] = $this->getManager($tag);
        }

        return $managers;
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
