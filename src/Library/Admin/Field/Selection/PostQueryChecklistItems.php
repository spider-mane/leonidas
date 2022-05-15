<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\ChecklistItemsProviderInterface;

class PostQueryChecklistItems extends AbstractPostQuerySelection implements ChecklistItemsProviderInterface
{
    use PostChecklistItemsTrait;
}
