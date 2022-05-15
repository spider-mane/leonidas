<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Traits\TermSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\OptionsProviderInterface;

class TermQuerySelectOptions extends AbstractTermQuerySelection implements OptionsProviderInterface
{
    use TermSelectOptionsTrait;
}
