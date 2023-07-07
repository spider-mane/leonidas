<?php

namespace Leonidas\Contracts\Admin\Component\Capsule;

use Leonidas\Contracts\Admin\Component\Page\InteriorPageInterface;
use Leonidas\Enum\Admin\Page\AdminPageContext;

interface FlexPageCapsuleInterface extends MenuPageCapsuleInterface, SubmenuPageCapsuleInterface, InteriorPageInterface
{
    public function context(): AdminPageContext;
}
