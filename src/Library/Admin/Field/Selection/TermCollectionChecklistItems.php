<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Abstracts\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\ChecklistItemsProviderInterface;

class TermCollectionChecklistItems extends AbstractTermCollectionSelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
