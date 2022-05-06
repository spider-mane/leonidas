<?php

namespace Leonidas\Library\Core\Auth;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;

class CsrfManagerRepository implements CsrfManagerRepositoryInterface
{
    /**
     * @var CsrfManagerInterface[]
     */
    protected array $managers = [];

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

    public function getManager(string $tag): ?CsrfManagerInterface
    {
        return $this->managers[$tag] ?? null;
    }

    public function getManagerSelection(string ...$tags): array
    {
        $managers = [];

        foreach ($tags as $tag) {
            $managers[] = $this->getManager($tag);
        }

        return $managers;
    }

    public function addManager(string $tag, CsrfManagerInterface $manager)
    {
        $this->managers[$tag] = $manager;

        return $this;
    }
}
