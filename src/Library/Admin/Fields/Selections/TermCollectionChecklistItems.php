<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\ChecklistItemsProviderInterface;

class TermCollectionChecklistItems extends AbstractTermCollectionSelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
