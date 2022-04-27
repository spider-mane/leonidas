<?php

namespace Leonidas\Contracts\System\Model\Page;

interface PageRepositoryInterface
{
    public function select(int $id): PageInterface;
}
