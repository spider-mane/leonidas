<?php

namespace Leonidas\Contracts\System\Model;

interface FungibleRepositoryInterface
{
    public function delete(int $id): void;
}
