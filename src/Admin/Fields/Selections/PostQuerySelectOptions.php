<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections;

use WebTheory\Leonidas\Admin\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class PostQuerySelectOptions extends AbstractPostQuerySelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
