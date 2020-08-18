<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Leonidas\Fields\Selections\Traits\TermChecklistItemsTrait;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;

class TaxonomyChecklistItems extends AbstractTaxonomySelection implements ChecklistItemsProviderInterface
{
    use TermChecklistItemsTrait;
}
