<?php

namespace Leonidas\Library\Core\Auth;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use RuntimeException;

class CsrfManagerRepository implements CsrfManagerRepositoryInterface
{
    /**
     * @var CsrfManagerInterface[]
     */
    protected array $managers = [];

    public function __construct(protected string $namespace)
    {
        //
    }

    public function add(CsrfManagerInterface $manager): void
    {
        if (!array_key_exists($name = $manager->getName(), $this->managers)) {
            $this->managers[$name] = $manager;
        } else {
            throw new RuntimeException(
                "Manager with name \"$name\" is already present."
            );
        }
    }

    public function get(string $tag): CsrfManagerInterface
    {
        return $this->managers[$tag] ??= $this->createManager($tag);
    }

    protected function createManager(string $tag): CsrfManagerInterface
    {
        $user = wp_get_current_user()->ID;

        return new Nonce(
            "{$this->namespace}_{$user}_{$tag}_nonce",
            "{$this->namespace}_{$user}_{$tag}"
        );
    }
}
