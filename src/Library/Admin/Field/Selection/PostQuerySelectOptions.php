<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\OptionsProviderInterface;

class PostQuerySelectOptions extends AbstractPostQuerySelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
