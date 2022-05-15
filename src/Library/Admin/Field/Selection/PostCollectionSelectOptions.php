<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\OptionsProviderInterface;

class PostCollectionSelectOptions extends AbstractPostCollectionSelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
