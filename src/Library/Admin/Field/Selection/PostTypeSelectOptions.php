<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\OptionsProviderInterface;

class PostTypeSelectOptions extends AbstractPostTypeSelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
