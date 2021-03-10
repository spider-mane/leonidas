<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\TermSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class TermQuerySelectOptions extends AbstractTermQuerySelection implements OptionsProviderInterface
{
    use TermSelectOptionsTrait;
}
