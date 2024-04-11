<?php

namespace Leonidas\Contracts\System\Schema\Post;

use Leonidas\Contracts\System\Schema\SoftDeletingEntityManagerInterface;

interface PostEntityManagerInterface extends SoftDeletingEntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function fromGlobalQuery(): ?object;

    public function selectName(string $name): ?object;

    public function whereNames(string ...$names): object;

    public function whereUser(int $user): object;

    public function whereUserAndStatus(int $user, string $status): object;

    public function whereParentId(int $parentId): object;

    public function whereStatus(string $status): object;

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

    public function whereConnectedPostQuery(array $query): object;

    public function whereConnectedPostClause(array $clause): object;

    /**
     * @param int|array<int> $id
     */
    public function whereConnectedPost(string $postType, string $operator, int|array $id): object;

    public function whereHasConnectedPost(string $postType, int ...$id): object;

    public function whereConnectedPostsQuery(array $query): object;

    public function whereConnectedPostsClause(array $clause): object;

    /**
     * @param int|array<int> $id
     */
    public function whereConnectedPosts(string $postType, string $operator, int|array $id): object;

    public function whereHasConnectedPosts(string $postType, int ...$id): object;
}
