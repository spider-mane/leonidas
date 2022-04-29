<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Closure;
use Leonidas\Library\Core\Util\OutputBuffer;
use Leonidas\Library\System\Schema\Post\Traits\SwapsGlobalPostTrait;
use WP_Post;

trait ForcesTemplateTagsTrait
{
    use SwapsGlobalPostTrait;

    protected WP_Post $core;

    protected function templateTag(callable $tag): Closure
    {
        return fn () => $this->doPostTemplateTag($tag);
    }

    protected function doPostTemplateTag(callable $tag): string
    {
        $cached = $this->swapGlobalPost($this->core);

        $value = OutputBuffer::wrapFunction($tag);

        $this->restoreGlobalPost($cached);

        return $value;
    }
}
