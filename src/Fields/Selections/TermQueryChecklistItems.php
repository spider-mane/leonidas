<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class TermQueryChecklistItems extends AbstractTermQuerySelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
