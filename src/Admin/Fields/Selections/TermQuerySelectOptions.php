<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections;

use WebTheory\Leonidas\Admin\Fields\Selections\Traits\TermSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class TermQuerySelectOptions extends AbstractTermQuerySelection implements OptionsProviderInterface
{
    use TermSelectOptionsTrait;
}
