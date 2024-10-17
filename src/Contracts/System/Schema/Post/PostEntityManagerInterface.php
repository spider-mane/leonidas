<?php

namespace Leonidas\Contracts\System\Schema\Post;

use Leonidas\Contracts\System\Schema\SoftDeletingEntityManagerInterface;
use WP_Post;

interface PostEntityManagerInterface extends SoftDeletingEntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function fromGlobalQuery(): ?object;

    public function fromHomeQuery(): object;

    public function fromPost(WP_Post $post): object;

    public function byName(string $name): ?object;

    public function whereNames(string ...$names): object;

    public function whereUser(int $user): object;

    public function whereUserAndStatus(int $user, string $status): object;

    public function whereUserPublished(int $user): object;

    public function whereUserDrafted(int $user): object;

    public function whereParent(int $parent): object;

    public function byChild(int $child): ?object;

    public function whereStatus(string $status): object;

    public function byMetaQuery(array $query): ?object;

    public function byMetaClause(array $clause): ?object;

    /**
     * @param string|array<string> $value
     */
    public function byMeta(string $key, string $operator, string|array $value): ?object;

    public function byHasMeta(string $key, string $value): ?object;

    public function whereMetaQuery(array $query): object;

    public function whereMetaClause(array $clause): object;

    /**
     * @param string|array<string> $value
     */
    public function whereMeta(string $key, string $operator, string|array $value): object;

    public function whereHasMeta(string $key, string ...$value): object;

    public function whereTaxQuery(array $query): object;

    public function whereTaxClause(array $clause): object;

    /**
     * @param string|array<string> $slug
     */
    public function whereTerms(string $taxonomy, string $operator, string|array $slug): object;

    public function whereHasTerms(string $taxonomy, string ...$slug): object;

    /**
     * @param int|array<int> $id
     */
    public function whereTermsById(string $taxonomy, string $operator, int|array $id): object;

    public function whereHasTermsById(string $taxonomy, int ...$id): object;

    public function byFeaturedMedia(int $mediaId): ?object;

    public function whereFeaturedMedia(int $mediaId): object;

    /**
     *  one to one
     */
    public function byForOnePostQuery(array $query): ?object;

    public function byForOnePostClause(array $clause): ?object;

    public function byForOnePostCondition(string $as, string $operator, int|array $id): ?object;

    public function byForOnePost(string $as, int $id): ?object;

    /**
     *  one to many, one to one (aggregate value)
     */
    public function whereForOnePostQuery(array $query): object;

    public function whereForOnePostClause(array $clause): object;

    public function whereForOnePostCondition(string $as, string $operator, int|array $id): object;

    public function whereForOnePost(string $as, int $id): object;

    /**
     *  one to many
     */
    public function byForManyPostsQuery(array $query): ?object;

    public function byForManyPostsClause(array $clause): ?object;

    public function byForManyPostsCondition(string $as, string $operator, int|array $id): ?object;

    public function byForManyPosts(string $as, int $id): ?object;

    /**
     *  many to many, one to many
     */
    public function whereForManyPostsQuery(array $query): object;

    public function whereForManyPostsClause(array $clause): object;

    public function whereForManyPostsCondition(string $as, string $operator, int|array $id): object;

    public function whereForManyPosts(string $as, int $id): object;

    /**
     *  one to one
     */
    // public function byForOnePostQuery(array $query): ?object;

    // public function byForOnePostClause(array $clause): ?object;

    // public function byForOnePostCondition(string $postType, string $operator, int|array $id): ?object;

    public function byHasOnePost(int $id, string $as = null): ?object;

    /**
     *  one to one (aggregate value)
     */
    // public function whereForOnePostQuery(array $query): object;

    // public function whereForOnePostClause(array $clause): object;

    // public function whereForOnePostCondition(string $postType, string $operator, int|array $id): object;

    public function whereHasOnePost(int $id, string $as = null): object;

    /**
     *  one to many, many to many
     */
    // public function byForManyPostsQuery(array $query): object;

    // public function byForManyPostsClause(array $clause): object;

    // public function byForManyPostsCondition(string $postType, string $operator, int|array $id): ?object;

    public function byHasManyPosts(int $id, string $as = null): ?object;

    /**
     *  one to many, many to many
     */
    // public function whereForManyPostsQuery(array $query): object;

    // public function whereForManyPostsClause(array $clause): object;

    // public function whereForManyPostsCondition(string $postType, string $operator, int|array $id): object;

    public function whereHasManyPosts(int $id, string $as = null): object;
}
