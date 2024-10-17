<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\ModelConfigurationOptionHandlerInterface;

interface PostTypeOptionHandlerInterface extends ModelConfigurationOptionHandlerInterface
{
    public function handle(PostTypeInterface $postType, $value): void;
}
