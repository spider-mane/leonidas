<?php

namespace Leonidas\Contracts\Auth;

interface CsrfManagerRepositoryInterface
{
    public function add(CsrfManagerInterface $manager): void;

    public function get(string $tag): CsrfManagerInterface;
}
