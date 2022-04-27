<?php

namespace Leonidas\Contracts\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use WP_Query;

interface PostRepositoryInterface
{
    public function select(int $id): ?PostInterface;

    public function selectMany(int ...$ids): PostCollectionInterface;

    public function selectByName(string $name): ?PostInterface;

    public function selectManyByName(string ...$names): PostCollectionInterface;

    public function whereAuthor(AuthorInterface $author): PostCollectionInterface;

    public function whereAuthorDrafts(AuthorInterface $author): PostCollectionInterface;

    public function whereAuthorAll(AuthorInterface $author): PostCollectionInterface;

    public function whereStatus(PostStatusInterface $status): PostCollectionInterface;

    public function find(array $args): PostCollectionInterface;

    public function query(WP_Query $query): PostCollectionInterface;

    public function insert(PostInterface $post): void;

    public function update(PostInterface $post): void;

    public function delete(int $postId): void;

    public function trash(int $postId): void;

    public function selectAll(): PostCollectionInterface;
}
