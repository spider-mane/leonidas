<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class PostCollectionChecklistItems extends AbstractPostCollectionSelection implements ChecklistItemsProviderInterface
{
    use PostChecklistItemsTrait;
}
