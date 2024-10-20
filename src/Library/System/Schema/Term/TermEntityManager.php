<?php

namespace Leonidas\Library\System\Schema\Term;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use Leonidas\Contracts\System\Schema\Term\TermEntityManagerInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnWpErrorTrait;
use WP_Term;
use WP_Term_Query;

class TermEntityManager implements TermEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnWpErrorTrait;

    protected string $taxonomy;

    protected TermConverterInterface $entityConverter;

    protected EntityCollectionFactoryInterface $collectionFactory;

    public function __construct(
        string $taxonomy,
        TermConverterInterface $termConverter,
        EntityCollectionFactoryInterface $collectionFactory,
        protected $entryMap = []
    ) {
        $this->taxonomy = $taxonomy;
        $this->entityConverter = $termConverter;
        $this->collectionFactory = $collectionFactory;
    }

    public function byId(int $id): ?object
    {
        return $this->single(['include' => [$id]]);
    }

    public function selectTermTaxonomyId(int $ttId): ?object
    {
        return $this->single(['term_taxonomy_id' => $ttId]);
    }

    public function selectSlug(string $name): ?object
    {
        return $this->single(['slug' => $name]);
    }

    public function whereIds(int ...$ids): object
    {
        return $this->query(['include' => $ids]);
    }

    public function whereTermTaxonomyIds(int ...$ttIds): object
    {
        return $this->query(['term_taxonomy_id' => $ttIds]);
    }

    public function whereSlugs(string ...$names): object
    {
        return $this->query(['slug' => $names]);
    }

    public function whereParent(int $parentId): object
    {
        return $this->query(['parent' => $parentId]);
    }

    public function byChild(int $childId): ?object
    {
        return ($id = $this->getTermField($childId, 'parent'))
            ? $this->byId((int) $id)
            : null;
    }

    public function whereAncestor(int $ancestorId): object
    {
        return $this->query(['child_of' => $ancestorId]);
    }

    public function whereObjectIds(int ...$objects): object
    {
        return $this->query(['object_ids' => $objects]);
    }

    public function all(): object
    {
        return $this->query([]);
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
     */
    public function query(array $args): object
    {
        return $this->gerCollectionFromQuery($this->getQuery($args));
    }

    public function single(array $args): ?object
    {
        return ($terms = $this->getTerms($args))
            ? $this->convertEntity(reset($terms))
            : null;
    }

    public function fetch(int $id): ?object
    {
        return $this->resolveFound(get_term($id, $this->taxonomy, OBJECT));
    }

    public function spawn(array $data): object
    {
        return $this->convertEntity(new WP_Term((object) $data));
    }

    public function insert(array $data): void
    {
        $this->throwExceptionIfWpError(
            wp_insert_term(
                $data['name'],
                $this->taxonomy,
                $this->normalizeDataForEntry($data)
            )
        );
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfWpError(
            wp_update_term(
                $id,
                $this->taxonomy,
                $this->normalizeDataForEntry($data)
            )
        );
    }

    public function delete(int $id): void
    {
        $this->throwExceptionIfWpError(
            wp_delete_term($id, $this->taxonomy)
        );
    }

    protected function getQuery(array $args): WP_Term_Query
    {
        return new WP_Term_Query($this->normalizeQueryArgs($args));
    }

    protected function getTerms(array $args): array
    {
        return $this->getQuery($args)->terms;
    }

    protected function getTermField(int $id, string $field): ?string
    {
        return get_term_field($field, $id, $this->taxonomy, 'raw');
    }

    protected function gerCollectionFromQuery(WP_Term_Query $query): object
    {
        return $this->createCollection(...$query->get_terms());
    }

    protected function normalizeQueryArgs(array $args): array
    {
        return [
            'taxonomy' => $this->taxonomy,
        ] + $args + [
            'hide_empty' => false,
        ];
    }

    protected function normalizeDataForEntry(array $data): array
    {
        return [
            'taxonomy' => $this->taxonomy,
            'parent' => is_taxonomy_hierarchical($this->taxonomy)
                ? $data['parent']
                : 0,
        ] + $data;
    }

    protected function resolveFound($result): ?object
    {
        return $result instanceof WP_Term ? $this->convertEntity($result) : null;
    }

    protected function convertEntity(WP_Term $term): object
    {
        return $this->entityConverter->convert($term);
    }

    protected function createCollection(WP_Term ...$terms): object
    {
        return $this->collectionFactory->createEntityCollection(
            ...array_map([$this, 'convertEntity'], $terms)
        );
    }
}
