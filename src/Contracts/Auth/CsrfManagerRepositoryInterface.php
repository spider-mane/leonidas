<?php

namespace Leonidas\Contracts\Auth;

interface CsrfManagerRepositoryInterface
{
    public function getManager(string $tag): ?CsrfManagerInterface;

    /**
     * @return CsrfManagerInterface[]
     */
    public function getManagers(): array;

    /**
     * @return CsrfManagerInterface[]
     */
    public function getManagerSelection(string ...$tags): array;
}
