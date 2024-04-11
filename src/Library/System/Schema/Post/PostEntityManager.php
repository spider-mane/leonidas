<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;
use Leonidas\Contracts\System\Schema\Post\QueryContextResolverInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\RelatablePostKeyInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnWpErrorTrait;
use WP_Post;
use WP_Query;

class PostEntityManager implements PostEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnWpErrorTrait;

    protected ?QueryFactoryInterface $queryFactory = null;

    protected QueryContextResolverInterface $contextResolver;

    public function __construct(
        protected string $postType,
        protected PostConverterInterface $postConverter,
        protected EntityCollectionFactoryInterface $collectionFactory,
        protected RelatablePostKeyInterface $keyResolver,
        ?QueryFactoryInterface $queryFactory = null,
        ?QueryContextResolverInterface $contextResolver = null,
        protected array $entryMap = []
    ) {
        if ($queryFactory) {
            $this->queryFactory = $queryFactory;
            $this->contextResolver = $contextResolver ?? new QueryContextResolver();
        }
    }

    public function fromGlobalQuery(): ?object
    {
        return $this->queryFactory?->createQuery($GLOBALS['wp_query']);
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
     * @link https://developer.wordpress.org/reference/classes/wp_meta_query/__construct/
     */
    public function whereMetaQuery(array $query): object
    {
        return $this->query(['meta_query' => $query]);
    }

    public function whereMetaClause(array $clause): object
    {
        return $this->whereMetaQuery([$clause]);
    }

    public function whereMeta(string $key, string $operator, string|array $value): object
    {
        return $this->whereMetaClause([
            'key' => $key,
            'value' => $value,
            'compare' => $operator,
        ]);
    }

    public function whereHasMeta(string $key, string ...$value): object
    {
        return $this->whereMeta($key, 'IN', $value);
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/wp_tax_query/__construct/
     */
    public function whereTaxQuery(array $query): object
    {
        return $this->query(['tax_query' => $query]);
    }

    public function whereTaxClause(array $clause): object
    {
        return $this->whereTaxQuery([$clause]);
    }

    public function whereTerms(string $taxonomy, string $operator, string|array $slug): object
    {
        return $this->whereTaxClause([
            'field' => 'slug',
            'taxonomy' => $taxonomy,
            'terms' => $slug,
            'operator' => $operator,
        ]);
    }

    public function whereHasTerms(string $taxonomy, string ...$slug): object
    {
        return $this->whereTerms($taxonomy, 'IN', $slug);
    }

    public function whereTermsById(string $taxonomy, string $operator, int|array $id): object
    {
        return $this->whereTaxClause([
            'field' => 'term_id',
            'taxonomy' => $taxonomy,
            'terms' => $id,
            'operator' => $operator,
        ]);
    }

    public function whereHasTermsById(string $taxonomy, int ...$id): object
    {
        return $this->whereTermsById($taxonomy, 'IN', $id);
    }

    public function whereConnectedPostQuery(array $query): object
    {
        return $this->whereMetaQuery($this->normalizeConnectedPostQuery($query));
    }

    public function whereConnectedPostClause(array $clause): object
    {
        return $this->whereConnectedPostQuery([$clause]);
    }

    public function whereConnectedPost(string $postType, string $operator, int|array $id): object
    {
        return $this->whereConnectedPostClause([
            'post_type' => $postType,
            'post_id' => $id,
            'compare' => $operator,
        ]);
    }

    public function whereHasConnectedPost(string $postType, int ...$id): object
    {
        return $this->whereConnectedPost($postType, 'IN', $id);
    }

    public function whereConnectedPostsQuery(array $query): object
    {
        return $this->whereTaxQuery($this->normalizeConnectedPostsQuery($query));
    }

    public function whereConnectedPostsClause(array $clause): object
    {
        return $this->whereConnectedPostsQuery([$clause]);
    }

    public function whereConnectedPosts(string $postType, string $operator, int|array $id): object
    {
        return $this->whereConnectedPostsClause([
            'post_type' => $postType,
            'post_id' => $id,
            'operator' => $operator,
        ]);
    }

    public function whereHasConnectedPosts(string $postType, int ...$id): object
    {
        return $this->whereConnectedPosts($postType, 'IN', $id);
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

    public function relatedPostTypeKey(string $postType): string
    {
        return $this->keyResolver->getPostTypeKey($postType);
    }

    public function relatedPostKey(string $postType): string
    {
        return $this->keyResolver->getPostKey($postType);
    }

    protected function stringify(int ...$ids): array
    {
        return array_map(strval(...), $ids);
    }

    /**
     * @param int|array<int> $id
     *
     * @return string|array<string>
     */
    protected function stringifyMixed(int|array $id): string|array
    {
        return is_int($id) ? (string) $id : $this->stringify(...$id);
    }

    protected function getQuery(array $args): WP_Query
    {
        return new WP_Query($this->normalizeQueryArgs($args));
    }

    protected function normalizeQueryArgs(array $args): array
    {
        return [
            'post_type' => $this->postType,
        ] + $args + [
            'post_status' => 'publish',
            'posts_per_page' => -1,
            // 'orderby' => 'name',
            // 'order' => 'ASC',
        ];
    }

    protected function normalizeConnectedPostQuery(array $query): array
    {
        $relation = $this->extractClauseRelation($query);

        foreach ($query as &$clause) {
            $clause = [
                'type' => 'NUMERIC',
                'type_key' => '',
                'key' => $this->extractRelatedPostKey($clause),
                'value' => $this->extractRelatedPost($clause),
            ] + $clause;
        }

        return $this->withClauseRelation($query, $relation);
    }

    protected function normalizeConnectedPostsQuery(array $query): array
    {
        $relation = $this->extractClauseRelation($query);

        foreach ($query as &$clause) {
            $clause = [
                'field' => 'slug',
                'include_children' => false,
                'taxonomy' => $this->extractRelatedPostTypeKey($clause),
                'terms' => $this->extractRelatedPost($clause),
            ] + $clause;
        }

        return $this->withClauseRelation($query, $relation);
    }

    protected function extractClauseRelation(array &$query): ?string
    {
        return $this->extractArg($query, 'relation');
    }

    protected function withClauseRelation(array $query, ?string $relation)
    {
        if ($relation) {
            $query['relation'] = $relation;
        }

        return $query;
    }

    protected function extractRelatedPostTypeKey(array &$clause): string
    {
        return $this->relatedPostTypeKey(
            $this->extractArg($clause, 'post_type')
        );
    }

    protected function extractRelatedPostKey(array &$clause): string
    {
        return $this->relatedPostKey($this->extractArg($clause, 'post_type'));
    }

    /**
     * @return string|array<string>
     */
    protected function extractRelatedPost(array &$clause): string|array
    {
        return $this->stringifyMixed($this->extractArg($clause, 'post_id'));
    }

    protected function extractArg(array &$args, string $key, mixed $default = null): mixed
    {
        $val = $args[$key] ?? $default;

        unset($args[$key]);

        return $val;
    }

    protected function normalizeDataForEntry(array $data, int $id = 0): array
    {
        return [
            'ID' => $id,
            'post_type' => $this->postType,
            'post_parent' => is_post_type_hierarchical($this->postType)
                ? $data['post_parent']
                : 0,
        ] + $this->normalizeMappedEntries($data);
    }

    protected function normalizeMappedEntries(array $data): array
    {
        $methods = [
            'meta' => $this->normalizeMetaMappedEntry(...),
            'tax' => $this->normalizeTaxMappedEntry(...),
            'one' => $this->normalizeOneMappedEntry(...),
            'many' => $this->normalizeManyMappedEntry(...),
        ];

        foreach ($data as $prop => $val) {
            $driver = $this->entryMap[$prop] ?? null;

            if (isset($driver)) {
                $data = $methods[$driver]($data, $prop, $val);

                unset($data[$prop]);

                continue;
            }
        }

        return $data;
    }

    protected function normalizeMetaMappedEntry(array $data, string $prop, mixed $val): array
    {
        $data['meta_input'][$prop] = $val;

        return $data;
    }

    protected function normalizeTaxMappedEntry(array $data, string $prop, mixed $val): array
    {
        $data['tax_input'][$prop] = $val;

        return $data;
    }

    protected function normalizeOneMappedEntry(array $data, string $prop, mixed $val): array
    {
        return $this->normalizeMetaMappedEntry(
            $data,
            $this->relatedPostKey($prop),
            (string) $val
        );
    }

    protected function normalizeManyMappedEntry(array $data, string $prop, mixed $val): array
    {
        return $this->normalizeTaxMappedEntry(
            $data,
            $this->relatedPostTypeKey($prop),
            $this->stringifyMixed($val)
        );
    }

    protected function resolveFound($result): ?object
    {
        return $result instanceof WP_Post
            ? $this->convertEntity($result)
            : null;
    }

    protected function convertEntity(WP_Post $post): object
    {
        return $this->postConverter->convert($post);
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
            ...array_map($this->convertEntity(...), $posts)
        );
    }
}
