<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\Admin\Field\Selection\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\Field\Selection\ChecklistItemsProviderInterface;

class TaxonomyChecklistItems extends AbstractTaxonomySelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
