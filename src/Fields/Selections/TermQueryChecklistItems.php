<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsInterface;

class TermQueryChecklistItems extends AbstractTermQuerySelection implements ChecklistItemsInterface
{
    use TermChecklistItemsTrait;
}
