<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Term;
use WebTheory\Leonidas\Util\TermCollection;
use WebTheory\Saveyour\Contracts\ChecklistItemsInterface;

class TermCollectionChecklistItems extends AbstractTermChecklistItems implements ChecklistItemsInterface
{
    /**
     * @var TermCollection
     */
    protected $collection;

    /**
     *
     */
    public function __construct(TermCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return WP_Term[]
     */
    public function provideItemsAsRawData(): array
    {
        return $this->collection->getTerms();
    }
}
