<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;
use Leonidas\Contracts\System\Schema\Post\QueryContextResolverInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\RelatablePostKeyInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\UsesIdsAsStringsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnWpErrorTrait;
use WP_Post;
use WP_Query;

class PostEntityManager implements PostEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnWpErrorTrait;
    use UsesIdsAsStringsTrait;

    protected readonly QueryContextResolverInterface $contextResolver;

    protected readonly array $entryMap;

    protected readonly array $insertionStrategies;

    public function __construct(
        protected readonly string $postType,
        protected readonly PostConverterInterface $postConverter,
        protected readonly EntityCollectionFactoryInterface $collectionFactory,
        protected readonly RelatablePostKeyInterface $keyResolver,
        protected readonly ?QueryFactoryInterface $queryFactory = null,
        ?QueryContextResolverInterface $contextResolver = null,
        array $entryMap = []
    ) {
        $this->contextResolver = $contextResolver ?? new QueryContextResolver();
        $this->entryMap = $this->getDefaultEntries() + $entryMap;
        $this->insertionStrategies = $this->defineInsertionStrategies();
    }

    public function fromGlobalQuery(): ?object
    {
        return $this->queryFactory?->createQuery($GLOBALS['wp_query']);
    }

    public function fromHomeQuery(): object
    {
        return $this->fromGlobalQuery();
    }

    public function fromPost(WP_Post $post): object
    {
        return $this->convertEntity($post);
    }

    public function byId(int $id): ?object
    {
        return $this->single(['p' => $id]);
    }

    public function whereIds(int ...$ids): object
    {
        return $this->query(['post__in' => $ids]);
    }

    public function byName(string $name): ?object
    {
        return $this->single(['name' => $name]);
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

    public function whereUserDrafted(int $user): object
    {
        return $this->whereUserAndStatus($user, 'draft');
    }

    public function whereUserPublished(int $user): object
    {
        return $this->whereUserAndStatus($user, 'published');
    }

    public function whereParent(int $parent): object
    {
        return $this->query(['post_parent' => $parent]);
    }

    public function byChild(int $child): ?object
    {
        return ($id = $this->getPostField($child, 'post_parent'))
            ? $this->byId((int) $id)
            : null;
    }

    public function whereStatus(string $status): object
    {
        return $this->query(['post_status' => $status]);
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/wp_meta_query/__construct/
     */
    public function byMetaQuery(array $query): ?object
    {
        return $this->single(['meta_query' => $query]);
    }

    public function byMetaClause(array $clause): ?object
    {
        return $this->byMetaQuery([$clause]);
    }

    public function byMeta(string $key, string $operator, string|array $value): ?object
    {
        return $this->byMetaClause([
            'key' => $key,
            'value' => $value,
            'compare' => $operator,
        ]);
    }

    public function byHasMeta(string $key, string $value): ?object
    {
        return $this->byMeta($key, '=', $value);
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

    public function byFeaturedMedia(int $mediaId): ?object
    {
        return $this->byHasMeta('_thumbnail_id', $this->stringifyId($mediaId));
    }

    public function whereFeaturedMedia(int $mediaId): object
    {
        return $this->whereHasMeta(
            '_thumbnail_id',
            $this->stringifyId($mediaId)
        );
    }

    public function byForOnePostQuery(array $query): ?object
    {
        return $this->byMetaQuery($this->normalizeHasPostQuery($query));
    }

    public function byForOnePostClause(array $clause): ?object
    {
        return $this->byForOnePostQuery([$clause]);
    }

    public function byForOnePostCondition(string $as, string $operator, int|array $id): ?object
    {
        return $this->byForOnePostClause([
            'post_type' => $as,
            'post_id' => $id,
            'compare' => $operator,
        ]);
    }

    public function byForOnePost(string $as, int $id): ?object
    {
        return $this->byForOnePostCondition($as, '=', $id);
    }

    public function whereForOnePostQuery(array $query): object
    {
        return $this->whereMetaQuery(
            $this->normalizeHasPostQuery($query)
        );
    }

    public function whereForOnePostClause(array $clause): object
    {
        return $this->whereForOnePostQuery([$clause]);
    }

    public function whereForOnePostCondition(string $as, string $operator, int|array $id): object
    {
        return $this->whereForOnePostClause([
            'post_type' => $as,
            'post_id' => $id,
            'compare' => $operator,
        ]);
    }

    public function whereForOnePost(string $as, int $id): object
    {
        return $this->whereForOnePostCondition($as, '=', $id);
    }

    public function byForManyPostsQuery(array $query): ?object
    {
        return $this->byForOnePostQuery($query);
    }

    public function byForManyPostsClause(array $clause): ?object
    {
        return $this->byForOnePostClause($clause);
    }

    public function byForManyPostsCondition(string $as, string $operator, int|array $id): ?object
    {
        return $this->byForOnePostCondition($as, $operator, $id);
    }

    public function byForManyPosts(string $as, int $id): ?object
    {
        return $this->byForOnePost($as, $id);
    }

    public function whereForManyPostsQuery(array $query): object
    {
        return $this->whereForOnePostQuery($query);
    }

    public function whereForManyPostsClause(array $clause): object
    {
        return $this->whereForOnePostClause($clause);
    }

    public function whereForManyPostsCondition(string $as, string $operator, int|array $id): object
    {
        return $this->whereForOnePostCondition($as, $operator, $id);
    }

    public function whereForManyPosts(string $as, int $id): object
    {
        return $this->whereForOnePost($as, $id);
    }

    public function byHasOnePost(int $id, string $as = null): ?object
    {
        return ($resolved = $this->getReferencedOne($id))
            ? $this->byId($resolved)
            : null;
    }

    public function whereHasOnePost(int $id, string $as = null): object
    {
        return ($resolved = $this->getReferencedMany($id))
            ? $this->whereIds(...$resolved)
            : null;
    }

    public function byHasManyPosts(int $id, string $as = null): ?object
    {
        return $this->byHasOnePost($id);
    }

    public function whereHasManyPosts(int $id, string $as = null): object
    {
        return $this->whereHasOnePost($id);
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
        return ($posts = $this->getPosts($args))
            ? $this->convertEntity(reset($posts))
            : null;
    }

    /**
     * @link https://developer.wordpress.org/reference/functions/wp_insert_post/
     */
    public function insert(array $data): void
    {
        // $data = $this->normalizeDataForEntry($data);
        // $polyInput = $this->extractPolyInput($data);

        // $this->throwExceptionIfWpError($id = wp_insert_post($data));
        // $this->processPolyMetaInput($id, $polyInput);

        $extra = $this->extractArgsMapped($data, $this->getInputSpecialKeys());
        $data = $this->normalizeDataForEntry($data);
        $api = $this->extractArgsMapped($data, $this->getInputApiKeys());

        $this->throwExceptionIfWpError($id = wp_insert_post($data));
        $this->doInputActions($id, $api + $extra);
    }

    /**
     * @link https://developer.wordpress.org/reference/functions/wp_update_post/
     */
    public function update(int $id, array $data): void
    {
        // $data = $this->normalizeDataForEntry($data, $id);
        // $polyInput = $this->extractPolyInput($data);

        // $this->throwExceptionIfWpError(wp_update_post($data));
        // $this->processPolyMetaInput($id, $polyInput);

        $extra = $this->extractArgsMapped($data, $this->getInputSpecialKeys());
        $data = $this->normalizeDataForEntry($data, $id);
        $api = $this->extractArgsMapped($data, $this->getInputApiKeys());

        $this->throwExceptionIfWpError(wp_update_post($data));
        $this->doInputActions($id, $api + $extra);
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

    protected function getDefaultEntries(): array
    {
        return [
            'thumbnail' => 'meta:_thumbnail_id',
        ];
    }

    protected function relatedPostKey(string $as): string
    {
        return $this->keyResolver->getPostKey($as);
    }

    protected function referencedPostKey(?string $as = null): string
    {
        return $this->relatedPostKey($as ? $as : $this->postType);
    }

    protected function getReferencedOne(int $id, ?string $as = null): ?int
    {
        return ($value = $this->getPostMeta($id, $this->referencedPostKey($as)))
            ? $this->normalizeId($value)
            : null;
    }

    /**
     * @return list<int>
     */
    protected function getReferencedMany(int $id, ?string $as = null): array
    {
        return $this->normalizeIds(
            ...$this->getPostMetaSet($id, $this->referencedPostKey($as))
        );
    }

    protected function getQuery(array $args): WP_Query
    {
        return new WP_Query($this->normalizeQueryArgs($args));
    }

    protected function getPosts(array $args): array
    {
        return $this->getQuery($this->normalizeQueryArgs($args))->posts;
    }

    protected function getPostField(int $id, string $field): string
    {
        return get_post_field($field, $id, 'raw');
    }

    protected function getPostMeta(int $id, string $key): ?string
    {
        return get_post_meta($id, $key, true) ?: null;
    }

    /**
     * @return list<string>
     */
    protected function getPostMetaSet(int $id, string $key): array
    {
        return get_post_meta($id, $key, false) ?: [];
    }

    protected function normalizeDataForEntry(array $data, int $id = 0): array
    {
        $data = [
            'ID' => $id,
            'post_type' => $this->postType,
            'post_parent' => is_post_type_hierarchical($this->postType)
                ? $data['post_parent']
                : 0,
        ] + $data;

        return $data + $this->normalizeMappedEntries($data);
    }

    protected function normalizeQueryArgs(array $args): array
    {
        return [
            'post_type' => $this->postType,
        ] + $args + [
            'post_status' => 'publish',
            'posts_per_page' => -1,
            // * Consider the following
            // 'orderby' => 'name',
            // 'order' => 'ASC',
        ];
    }

    protected function normalizeHasPostQuery(array $query): array
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

    protected function extractPolyInput(array &$data): array
    {
        return $this->extractArg($data, 'poly_input', []);
    }

    protected function extractClauseRelation(array &$query): ?string
    {
        return $this->extractArg($query, 'relation');
    }

    protected function withClauseRelation(array $query, ?string $relation): array
    {
        if ($relation) {
            $query['relation'] = $relation;
        }

        return $query;
    }

    protected function extractRelatedPostTypeKey(array &$clause): string
    {
        return $this->relatedPostKey(
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
        return $this->stringifyIdx($this->extractArg($clause, 'post_id'));
    }

    protected function extractArg(array &$args, string $key, mixed $default = null): mixed
    {
        $val = $args[$key] ?? $default;

        unset($args[$key]);

        return $val;
    }

    protected function extractArgsMapped(array &$args, array $map): array
    {
        $extracted = [];

        foreach ($map as $key => $default) {
            $extracted[$key] = $this->extractArg($args, $key, $default);
        }

        return $extracted;
    }

    protected function getInputApiKeys(): array
    {
        return [
            'poly_input' => [],
        ];
    }

    protected function getInputSpecialKeys(): array
    {
        return [
            'thumbnail' => null
        ];
    }

    protected function doInputActions(int $id, array $data): void
    {
        $this->processPolyMetaInput($id, $data['poly_input'] ?? []);
    }

    protected function processPolyMetaInput(int $id, array $input): void
    {
        foreach ($input as $key => $values) {
            $values = is_array($values) ? $values : [$values];

            foreach ($values as $value) {
                update_post_meta($id, $key, $value);
            }
        }
    }

    protected function getInsertionStrategies(): array
    {
        return $this->insertionStrategies;
    }

    protected function defineInsertionStrategies(): array
    {
        return [
            'meta' => $this->normalizeMetaMappedEntry(...),
            'tax' => $this->normalizeTaxMappedEntry(...),
            'poly' => $this->normalizePolyMappedEntry(...),
            'has_one' => $this->normalizeHasOneMappedEntry(...),
            'has_many' => $this->normalizeHasManyMappedEntry(...),
            'for_one' => $this->normalizeForOneMappedEntry(...),
            'for_many' => $this->normalizeForManyMappedEntry(...),
        ];
    }

    protected function normalizeMappedEntries(array $data): array
    {
        $strategies = $this->getInsertionStrategies();

        foreach ($data as $prop => $val) {
            $strategy = $this->entryMap[$prop] ?? null;

            if (isset($strategy)) {
                $this->parsePropStrategy($prop, $strategy);

                $data = $strategies[$strategy]($data, $prop, $val);

                unset($data[$prop]);

                continue;
            }
        }

        return $data;
    }

    protected function parsePropStrategy(string &$prop, string &$strategy): void
    {
        $delim = ':';

        if (str_contains($strategy, $delim)) {
            $parts = explode($delim, $strategy, 2);
            $prop = $parts[1];
            $strategy = $parts[0];
        }
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

    protected function normalizePolyMappedEntry(array $data, string $prop, mixed $val): array
    {
        $data['poly_input'][$prop] = $val;

        return $data;
    }

    protected function normalizeForOneMappedEntry(array $data, string $prop, mixed $val): array
    {
        return $this->normalizeMetaMappedEntry(
            $data,
            $this->relatedPostKey($prop),
            $this->stringifyId($val)
        );
    }

    protected function normalizeForManyMappedEntry(array $data, string $prop, mixed $val): array
    {
        return $this->normalizePolyMappedEntry(
            $data,
            $this->relatedPostKey($prop),
            $this->stringifyIds($val)
        );
    }

    protected function normalizeHasOneMappedEntry(array $data, string $prop, mixed $val): array
    {
        $key = $this->referencedPostKey();

        update_post_meta($val, $key, $this->stringifyId($data['ID']));

        return $data;
    }

    protected function normalizeHasManyMappedEntry(array $data, string $prop, mixed $val): array
    {
        $key = $this->referencedPostKey();

        foreach ($val as $post) {
            update_post_meta($post, $key, $this->stringifyId($data['ID']));
        };

        return $data;
    }

    protected function getCollectionFromQuery(WP_Query $query): object
    {
        return $this->isQueryContext()
            ? $this->createQuery($query)
            : $this->createCollection(...$query->posts);
    }

    protected function convertEntity(WP_Post $post): object
    {
        return $this->postConverter->convert($post);
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
