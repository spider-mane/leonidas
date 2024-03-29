<?php

namespace Leonidas\Library\Admin\Field\Selection;

use Leonidas\Library\System\Schema\Term\TermCollection;
use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;
use WP_Term;

abstract class AbstractTermCollectionSelection extends AbstractTermSelectionProvider implements SelectionProviderInterface
{
    protected TermCollection $collection;

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
