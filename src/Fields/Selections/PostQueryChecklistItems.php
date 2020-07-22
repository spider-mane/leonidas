<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsInterface;

class PostQueryChecklistItems extends AbstractPostQuerySelection implements ChecklistItemsInterface
{
    use PostChecklistItemsTrait;
}
