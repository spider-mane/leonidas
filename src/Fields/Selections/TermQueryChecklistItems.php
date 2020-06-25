<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Term;
use WP_Term_Query;
use WebTheory\Saveyour\Contracts\SelectionProviderInterface;

class TermQueryChecklistItems extends AbstractTermChecklistItems implements SelectionProviderInterface
{
    /**
     * @var WP_Term_Query
     */
    protected $query;

    /**
     *
     */
    public function __construct(WP_Term_Query $query)
    {
        $this->query = $query;
    }

    /**
     * @return WP_Term[]
     */
    protected function provideItemsAsRawData(): array
    {
        return $this->query->get_terms();
    }
}
