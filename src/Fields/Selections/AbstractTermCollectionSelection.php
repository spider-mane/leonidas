<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Term;
use WebTheory\Leonidas\Util\TermCollection;
use WebTheory\Saveyour\Contracts\SuperSelectionProviderInterface;

abstract class AbstractTermCollectionSelection extends AbstractTermSuperSelection implements SuperSelectionProviderInterface
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
