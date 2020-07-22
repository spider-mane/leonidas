<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\TermSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\SelectOptionsProviderInterface;

class TermQuerySelectOptions extends AbstractTermQuerySelection implements SelectOptionsProviderInterface
{
    use TermSelectOptionsTrait;
}
