<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Abstracts\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\ChecklistItemsProviderInterface;

class TermQueryChecklistItems extends AbstractTermQuerySelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
