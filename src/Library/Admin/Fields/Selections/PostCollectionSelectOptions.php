<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\OptionsProviderInterface;

class PostCollectionSelectOptions extends AbstractPostCollectionSelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
