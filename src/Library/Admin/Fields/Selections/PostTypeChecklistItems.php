<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\PostChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\ChecklistItemsProviderInterface;

class PostTypeChecklistItems extends AbstractPostTypeSelection implements ChecklistItemsProviderInterface
{
    use PostChecklistItemsTrait;
}
