<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\TermSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class TermCollectionSelectOptions extends AbstractTermCollectionSelection implements OptionsProviderInterface
{
    use TermSelectOptionsTrait;
}
