<?php

namespace Leonidas\Library\System\Schema\Term;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use Leonidas\Contracts\System\Schema\Term\TermEntityManagerInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnErrorTrait;
use WP_Term;
use WP_Term_Query;

class TermEntityManager implements TermEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnErrorTrait;

    protected string $taxonomy;

    protected TermConverterInterface $entityConverter;

    protected EntityCollectionFactoryInterface $collectionFactory;

    public function __construct(
        string $taxonomy,
        TermConverterInterface $termConverter,
        EntityCollectionFactoryInterface $collectionFactory
    ) {
        $this->taxonomy = $taxonomy;
        $this->entityConverter = $termConverter;
        $this->collectionFactory = $collectionFactory;
    }

    public function select(int $id): object
    {
        return $this->convertEntity(get_term($id, $this->taxonomy, OBJECT));
    }

    public function whereIds(int ...$ids): object
    {
        return $this->find([
            'include' => $ids,
            'hide_empty' => false,
        ]);
    }

    public function selectByTermTaxonomyId(int $termTaxonomyId): object
    {
        return $this->convertEntity(
            get_term_by(
                'term_taxonomy_id',
                $termTaxonomyId,
                $this->taxonomy,
                OBJECT
            )
        );
    }

    public function whereTermTaxonomyIds(int ...$termTaxonomyIds): object
    {
        return $this->find([
            'term_taxonomy_id' => $termTaxonomyIds,
            'hide_empty' => false,
        ]);
    }

    public function selectBySlug(string $name): object
    {
        return $this->convertEntity(
            get_term_by('slug', $name, $this->taxonomy, OBJECT)
        );
    }

    public function whereSlugs(string ...$names): object
    {
        return $this->find([
            'slug' => $names,
            'hide_empty' => false,
        ]);
    }

    public function whereParentId(int $parentId): object
    {
        return $this->find([
            'parent' => $parentId,
            'hide_empty' => false,
        ]);
    }

    public function whereChildOf(int $parentId): object
    {
        return $this->find([
            'child_of' => $parentId,
            'hide_empty' => false,
        ]);
    }

    public function whereObjectIds(int ...$objects): object
    {
        return $this->find([
            'object_ids' => $objects,
            'hide_empty' => false,
        ]);
    }

    public function all(): object
    {
        return $this->find([
            'hide_empty' => false,
        ]);
    }

    public function find(array $queryArgs): object
    {
        return $this->query(new WP_Term_Query($queryArgs));
    }

    public function query(WP_Term_Query $query): object
    {
        $query->query_vars['taxonomy'] = $this->taxonomy;

        return $this->createCollection(...$query->get_terms());
    }

    public function insert(array $data): void
    {
        $this->throwExceptionIfError(
            wp_insert_term(
                $data['name'],
                $this->taxonomy,
                $this->normalizeDataForEntry($data)
            )
        );
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfError(
            wp_update_term(
                $id,
                $this->taxonomy,
                $this->normalizeDataForEntry($data)
            )
        );
    }

    public function delete(int $id): void
    {
        $this->throwExceptionIfError(
            wp_delete_term($id, $this->taxonomy)
        );
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
