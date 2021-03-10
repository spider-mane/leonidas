<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\PostSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class PostQuerySelectOptions extends AbstractPostQuerySelection implements OptionsProviderInterface
{
    use PostSelectOptionsTrait;
}
