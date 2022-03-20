<?php

namespace Leonidas\Library\System\Schema\Post\Traits;

use Leonidas\Library\Core\Util\OutputBuffer;
use WP_Post;

trait UsesPostTemplateTagsTrait
{
    use SwapsGlobalPostTrait;

    protected WP_Post $post;

    protected function doPostTemplateTag(callable $function, bool $ob, ...$args): string
    {
        $cached = $this->swapGlobalPost($this->post);

        $value = $ob
            ? OutputBuffer::wrapFunction($function, $args)
            : call_user_func_array($function, $args);

        $this->restoreGlobalPost($cached);

        return $value;
    }
}
