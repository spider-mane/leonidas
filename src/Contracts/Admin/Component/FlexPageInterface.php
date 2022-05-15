<?php

namespace Leonidas\Contracts\Admin\Component;

use Leonidas\Enum\Admin\Page\AdminPageContext;

interface FlexPageInterface extends MenuPageInterface, SubmenuPageInterface, InteriorPageInterface
{
    public function getContext(): AdminPageContext;
}
