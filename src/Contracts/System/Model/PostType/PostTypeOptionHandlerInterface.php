<?php

namespace Leonidas\Contracts\System\Model\PostType;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeOptionHandlerInterface;

interface PostTypeOptionHandlerInterface extends BaseSystemModelTypeOptionHandlerInterface
{
    public function handle(PostTypeInterface $postType, $value): void;
}
