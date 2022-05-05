<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\OptionsProviderInterface;

class PostTypeSelectOptions extends AbstractPostTypeSelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
