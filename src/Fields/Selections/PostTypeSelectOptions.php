<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\SelectOptionsProviderInterface;

class PostTypeSelectOptions extends AbstractPostTypeSelection implements SelectOptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
