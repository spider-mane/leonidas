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
        return $this->query(['include' => $ids]);
    }

    public function selectByTermTaxonomyId(int $ttId): object
    {
        return $this->convertEntity(
            get_term_by(
                'term_taxonomy_id',
                $ttId,
                $this->taxonomy,
                OBJECT
            )
        );
    }

    public function whereTermTaxonomyIds(int ...$ttId): object
    {
        return $this->query(['term_taxonomy_id' => $ttId]);
    }

    public function selectBySlug(string $name): object
    {
        return $this->convertEntity(
            get_term_by('slug', $name, $this->taxonomy, OBJECT)
        );
    }

    public function whereSlugs(string ...$names): object
    {
        return $this->query(['slug' => $names]);
    }

    public function whereParentId(int $parentId): object
    {
        return $this->query(['parent' => $parentId]);
    }

    public function whereChildOf(int $parentId): object
    {
        return $this->query(['child_of' => $parentId]);
    }

    public function whereObjectIds(int ...$objects): object
    {
        return $this->query(['object_ids' => $objects]);
    }

    public function all(): object
    {
        return $this->query([]);
    }

    public function query(array $args): object
    {
        return $this->gerCollectionFromQuery(
            new WP_Term_Query($this->normalizeQueryArgs($args))
        );
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

    public function gerCollectionFromQuery(WP_Term_Query $query): object
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
