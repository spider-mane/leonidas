<?php

namespace Leonidas\Contracts\System\Schema;

interface SoftDeletingEntityManagerInterface extends EntityManagerInterface
{
    public function trash(int $id): void;

    public function recover(int $id): void;
}
