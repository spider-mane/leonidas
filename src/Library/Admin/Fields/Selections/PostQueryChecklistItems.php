<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class PostQueryChecklistItems extends AbstractPostQuerySelection implements ChecklistItemsProviderInterface
{
    use PostChecklistItemsTrait;
}
