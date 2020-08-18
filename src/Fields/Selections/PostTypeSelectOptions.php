<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class PostTypeSelectOptions extends AbstractPostTypeSelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
