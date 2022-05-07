<?php

namespace Leonidas\Library\Admin\Page\Layouts;

use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\ComponentCallback;

class PageLayoutCallback extends ComponentCallback implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
}
