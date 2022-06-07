<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\QueryContextResolverInterface;

class QueryContextResolver implements QueryContextResolverInterface
{
    public function isQueryContext(): bool
    {
        return isset($GLOBALS['wp_query']->query);
    }
}
