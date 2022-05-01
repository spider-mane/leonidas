<?php

namespace Leonidas\Contracts\System\Model;

interface SoftDeletingRepositoryInterface extends FungibleRepositoryInterface
{
    public function trash(int $id): void;

    public function recover(int $id): void;
}
