<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;
use Leonidas\Contracts\System\Schema\Post\QueryContextResolverInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnWpErrorTrait;
use WP_Post;
use WP_Query;

class PostEntityManager implements PostEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnWpErrorTrait;

    protected string $type;

    protected PostConverterInterface $entityConverter;

    protected EntityCollectionFactoryInterface $collectionFactory;

    protected ?QueryFactoryInterface $queryFactory = null;

    protected QueryContextResolverInterface $contextResolver;

    public function __construct(
        string $type,
        PostConverterInterface $postConverter,
        EntityCollectionFactoryInterface $collectionFactory,
        ?QueryFactoryInterface $queryFactory = null,
        ?QueryContextResolverInterface $contextResolver = null
    ) {
        $this->type = $type;
        $this->entityConverter = $postConverter;
        $this->collectionFactory = $collectionFactory;

        if ($queryFactory) {
            $this->queryFactory = $queryFactory;
            $this->contextResolver = $contextResolver ?? new QueryContextResolver();
        }
    }

    public function select(int $id): ?object
    {
        return $this->single(['post__in' => [$id]]);
    }

    public function selectName(string $name): ?object
    {
        return $this->single(['post_name__in' => [$name]]);
    }

    public function whereIds(int ...$ids): object
    {
        return $this->query(['post__in' => $ids]);
    }

    public function whereNames(string ...$names): object
    {
        return $this->query(['post_name__in' => $names]);
    }

    public function whereUser(int $user): object
    {
        return $this->query(['author' => $user, 'post_status' => 'any']);
    }

    public function whereUserAndStatus(int $user, string $status): object
    {
        return $this->query(['author' => $user, 'post_status' => $status]);
    }

    public function whereParentId(int $parentId): object
    {
        return $this->query(['post_parent' => $parentId]);
    }

    public function whereStatus(string $status): object
    {
        return $this->query(['post_status' => $status]);
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/wp_tax_query/__construct/
     */
    public function whereTaxQuery(array $args): object
    {
        return $this->query(['tax_query' => $args]);
    }

    public function whereTerm(string $taxonomy, int $termId): object
    {
        return $this->query([
            'tax_query' => [
                [
                    'field' => 'term_id',
                    'taxonomy' => $taxonomy,
                    'terms' => $termId,
                ],
            ],
        ]);
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/wp_meta_query/__construct/
     */
    public function whereMetaQuery(array $args): object
    {
        return $this->query(['meta_query' => $args]);
    }

    public function whereMeta(string $key, string $operator, $value): object
    {
        return $this->query([
            'meta_key' => $key,
            'meta_value' => $value,
            'meta_compare' => $operator,
        ]);
    }

    public function all(): object
    {
        return $this->query([]);
    }

    public function spawn(array $data): object
    {
        return $this->convertEntity(new WP_Post((object) $data));
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/WP_Query/parse_query/
     */
    public function query(array $args): object
    {
        return $this->getCollectionFromQuery($this->getQuery($args));
    }

    public function single(array $args): ?object
    {
        $posts = $this->getQuery($args)->get_posts();

        return $posts ? $this->convertEntity($posts[0]) : null;
    }

    /**
     * @link https://developer.wordpress.org/reference/functions/wp_insert_post/
     */
    public function insert(array $data): void
    {
        $this->throwExceptionIfWpError(
            wp_insert_post($this->normalizeDataForEntry($data))
        );
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfWpError(
            wp_update_post($this->normalizeDataForEntry($data, $id))
        );
    }

    public function delete(int $id): void
    {
        wp_delete_post($id, true);
    }

    public function trash(int $id): void
    {
        wp_trash_post($id);
    }

    public function recover(int $id): void
    {
        wp_untrash_post($id);
    }

    protected function getQuery(array $args): WP_Query
    {
        return new WP_Query($this->normalizeQueryArgs($args));
    }

    protected function normalizeQueryArgs($args): array
    {
        return [
            'post_type' => $this->type,
        ] + $args + [
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ];
    }

    protected function normalizeDataForEntry(array $data, int $id = 0): array
    {
        return [
            'ID' => $id,
            'post_type' => $this->type,
            'post_parent' => is_post_type_hierarchical($this->type)
                ? $data['post_parent']
                : 0,
        ] + $data;
    }

    protected function resolveFound($result): ?object
    {
        return $result instanceof WP_Post ? $this->convertEntity($result) : null;
    }

    protected function convertEntity(WP_Post $post): object
    {
        return $this->entityConverter->convert($post);
    }

    protected function getCollectionFromQuery(WP_Query $query): object
    {
        return $this->isQueryContext()
            ? $this->createQuery($query)
            : $this->createCollection(...$query->get_posts());
    }

    protected function isQueryContext(): bool
    {
        return isset($this->queryFactory)
            && $this->contextResolver->isQueryContext();
    }

    protected function createQuery(WP_Query $query): object
    {
        return $this->queryFactory->createQuery($query);
    }

    protected function createCollection(WP_Post ...$posts): object
    {
        return $this->collectionFactory->createEntityCollection(
            ...array_map([$this, 'convertEntity'], $posts)
        );
    }
}
