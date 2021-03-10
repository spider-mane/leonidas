<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class TermQueryChecklistItems extends AbstractTermQuerySelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
