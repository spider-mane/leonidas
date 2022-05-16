<?php

namespace Leonidas\Library\Admin\Component\Page\Layout;

use Leonidas\Contracts\Admin\Component\Page\AdminPageLayoutInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Component\ComponentCallback;

class PageLayoutCallback extends ComponentCallback implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
}
