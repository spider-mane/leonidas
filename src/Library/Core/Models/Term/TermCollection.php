<?php

namespace Leonidas\Library\Core\Models\Term;

use WP_Term;
use WP_Term_Query;

class TermCollection
{
    /**
     * @var WP_Term[]
     */
    protected $terms;

    /**
     *
     */
    public function __construct(WP_Term ...$terms)
    {
        $this->terms = $terms;
    }

    /**
     * @return WP_Term[]
     */
    public function getTerms(): array
    {
        return $this->terms;
    }

    /**
     *
     */
    public function get(string $property)
    {
        return array_map(function (WP_Term $term) use ($property) {
            return $term->{$property};
        }, $this->terms);
    }

    /**
     *
     */
    public function getIds()
    {
        return $this->get('term_id');
    }

    /**
     *
     */
    public function getNames()
    {
        return $this->get('name');
    }

    /**
     *
     */
    public function getSlugs()
    {
        return $this->get('slug');
    }

    /**
     *
     */
    public function append(WP_Term $term)
    {
        $this->terms[] = $term;
    }

    /**
     *
     */
    public function isEmpty(): bool
    {
        return empty($this->terms);
    }

    /**
     *
     */
    protected function diffCallback()
    {
        return function (WP_Term $term1, WP_Term $term2) {
            return $term1->term_id - $term2->term_id;
        };
    }

    /**
     *
     */
    public function without(TermCollection $collection)
    {
        return array_udiff(
            $this->getTerms(),
            $collection->getTerms(),
            $this->diffCallback()
        );
    }

    /**
     *
     */
    public function notIn(TermCollection $collection)
    {
        return array_udiff(
            $collection->getTerms(),
            $this->getTerms(),
            $this->diffCallback()
        );
    }

    /**
     *
     */
    public function diff(TermCollection $collection): array
    {
        $primary = $this->getTerms();
        $secondary = $collection->getTerms();
        $cb = $this->diffCallback();

        /*
         * if both primary and secondary are empty this will return false
         * because the "array_diff" family of functions returns an empty array
         * if the first array provided is empty itself. if both arrays are
         * empty this will return an empty array as there is no difference.
         */
        return !empty($primary)
            ? array_udiff($primary, $secondary, $cb)
            : array_udiff($secondary, $primary, $cb);
    }

    /**
     *
     */
    public function isDiff(TermCollection $collection): bool
    {
        return (bool) $this->diff($collection);
    }

    /**
     *
     */
    public static function fromQuery(WP_Term_Query $query): TermCollection
    {
        return new static(...$query->get_terms());
    }

    /**
     *
     */
    public static function create(array $args): TermCollection
    {
        return static::fromQuery(new WP_Term_Query($args));
    }

    /**
     *
     */
    public static function fromIds(int ...$ids): TermCollection
    {
        return static::create([
            'include' => $ids,
            'hide_empty' => false,
        ]);
    }
}
