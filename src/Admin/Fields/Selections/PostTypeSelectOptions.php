<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections;

use WebTheory\Leonidas\Admin\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class PostTypeSelectOptions extends AbstractPostTypeSelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
