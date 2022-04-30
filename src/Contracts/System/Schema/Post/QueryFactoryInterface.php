<?php

namespace Leonidas\Contracts\System\Schema\Post;

use WP_Query;

interface QueryFactoryInterface
{
    public function createQuery(WP_Query $query): object;
}
