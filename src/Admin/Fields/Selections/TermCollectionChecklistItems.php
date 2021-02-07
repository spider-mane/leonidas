<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections;

use WebTheory\Leonidas\Admin\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class TermCollectionChecklistItems extends AbstractTermCollectionSelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
