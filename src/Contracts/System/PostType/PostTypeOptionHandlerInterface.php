<?php

namespace Leonidas\Contracts\System\PostType;

use Leonidas\Contracts\System\BaseSystemModelTypeOptionHandlerInterface;

interface PostTypeOptionHandlerInterface extends BaseSystemModelTypeOptionHandlerInterface
{
    public function handle(PostTypeInterface $postType, $value): void;
}
