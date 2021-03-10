<?php

namespace WebTheory\Leonidas\Library\Admin\Fields\Selections;

use WP_Term;
use WebTheory\Leonidas\Library\Core\Util\TermCollection;
use WebTheory\Saveyour\Contracts\SelectionProviderInterface;

abstract class AbstractTermCollectionSelection extends AbstractTermSelectionProvider implements SelectionProviderInterface
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
    public function provideSelectionsData(): array
    {
        return $this->collection->getTerms();
    }
}
