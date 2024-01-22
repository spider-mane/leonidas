<?php

namespace Leonidas\Framework\App\Module;

use Leonidas\Contracts\System\Configuration\PostType\PostTypeFactoryInterface;
use Leonidas\Framework\Module\PostTypes as PostTypeModule;
use Leonidas\Library\System\Configuration\PostType\PostTypeFactory;

class PostTypes extends PostTypeModule
{
    protected function factory(): PostTypeFactoryInterface
    {
        return new PostTypeFactory();
    }
}
