<?php

namespace Leonidas\Contracts\Admin\Components;

use Leonidas\Enum\Admin\Page\AdminPageContext;

interface FlexPageInterface extends MenuPageInterface, SubmenuPageInterface, InteriorPageInterface
{
    public function getContext(): AdminPageContext;
}
