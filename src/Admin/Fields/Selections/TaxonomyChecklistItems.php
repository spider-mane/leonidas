<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections;

use WebTheory\Leonidas\Admin\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class TaxonomyChecklistItems extends AbstractTaxonomySelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
