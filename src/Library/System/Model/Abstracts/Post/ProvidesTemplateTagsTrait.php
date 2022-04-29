<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Closure;
use Leonidas\Library\Core\Util\OutputBuffer;

trait ProvidesTemplateTagsTrait
{
    protected function templateTag(callable $tag): Closure
    {
        return fn () => OutputBuffer::wrapFunction($tag);
    }

    protected function function(callable $function): Closure
    {
        return Closure::fromCallable($function);
    }
}
