<?php

namespace Leonidas\Library\Admin\Page\Layouts;

use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Library\Admin\ComponentCallback;
use Leonidas\Traits\CanBeRestrictedTrait;

class PageLayoutCallback extends ComponentCallback implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
}
