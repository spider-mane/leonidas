<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\ModelConfigurationInterface;

interface PostTypeInterface extends
    ModelConfigurationInterface,
    PostTypeInfoInterface,
    PostTypeCoreConfigInterface,
    PostTypePublicConfigInterface,
    PostTypeRestConfigInterface,
    PostTypeAdminConfigInterface
{
    //
}
