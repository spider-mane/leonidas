<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections;

use WebTheory\Leonidas\Admin\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class TermQueryChecklistItems extends AbstractTermQuerySelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
