<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeOptionHandlerInterface;

interface PostTypeOptionHandlerInterface extends BaseSystemModelTypeOptionHandlerInterface
{
    public function handle(PostTypeInterface $postType, $value): void;
}
