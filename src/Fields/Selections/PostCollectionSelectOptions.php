<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class PostCollectionSelectOptions extends AbstractPostCollectionSelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
