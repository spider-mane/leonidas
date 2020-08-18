<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class PostQueryChecklistItems extends AbstractPostQuerySelection implements ChecklistItemsProviderInterface
{
    use PostChecklistItemsTrait;
}
