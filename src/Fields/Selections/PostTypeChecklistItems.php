<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class PostTypeChecklistItems extends AbstractPostTypeSelection implements ChecklistItemsProviderInterface
{
    use PostChecklistItemsTrait;
}
