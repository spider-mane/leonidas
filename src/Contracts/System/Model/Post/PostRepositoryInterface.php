<?php

namespace Leonidas\Contracts\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\SoftDeletingRepositoryInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;

interface PostRepositoryInterface extends SoftDeletingRepositoryInterface
{
    public function fromGlobalQuery(): PostCollectionInterface;

    public function select(int $id): ?PostInterface;

    public function selectName(string $name): ?PostInterface;

    public function whereIds(int ...$ids): PostCollectionInterface;

    public function whereNames(string ...$names): PostCollectionInterface;

    public function whereAuthor(AuthorInterface $author): PostCollectionInterface;

    public function whereAuthorDrafts(AuthorInterface $author): PostCollectionInterface;

    public function whereAuthorAll(AuthorInterface $author): PostCollectionInterface;

    public function whereStatus(PostStatusInterface $status): PostCollectionInterface;

    public function whereTag(TagInterface $tag): PostCollectionInterface;

    public function whereCategory(CategoryInterface $category): PostCollectionInterface;

    public function query(array $args): PostCollectionInterface;

    public function all(): PostCollectionInterface;

    public function make(array $data): PostInterface;

    public function insert(PostInterface $post): void;

    public function update(PostInterface $post): void;
}
