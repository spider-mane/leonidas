<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections;

use WebTheory\Leonidas\Admin\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class PostCollectionSelectOptions extends AbstractPostCollectionSelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
