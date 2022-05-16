<?php

namespace Leonidas\Contracts\Admin\Component\Page;

use Leonidas\Enum\Admin\Page\AdminPageContext;

interface FlexPageInterface extends MenuPageInterface, SubmenuPageInterface, InteriorPageInterface
{
    public function getContext(): AdminPageContext;
}
