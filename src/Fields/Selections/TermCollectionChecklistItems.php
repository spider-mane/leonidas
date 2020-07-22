<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsInterface;

class TermCollectionChecklistItems extends AbstractTermCollectionSelection implements ChecklistItemsInterface
{
    use TermChecklistItemsTrait;
}
