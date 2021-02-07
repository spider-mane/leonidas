<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections;

use WebTheory\Leonidas\Admin\Fields\Selections\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class PostTypeChecklistItems extends AbstractPostTypeSelection implements ChecklistItemsProviderInterface
{
    use PostChecklistItemsTrait;
}
