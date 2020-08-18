<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class PostQuerySelectOptions extends AbstractPostQuerySelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
