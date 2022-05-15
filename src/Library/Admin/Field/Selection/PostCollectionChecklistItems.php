<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\ChecklistItemsProviderInterface;

class PostCollectionChecklistItems extends AbstractPostCollectionSelection implements ChecklistItemsProviderInterface
{
    use PostChecklistItemsTrait;
}
