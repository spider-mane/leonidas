<?php

declare(strict_types=1);

namespace Leonidas\Plugin\Access;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Library\System\Model\Post\PostQuery;

/**
 * @method static PostQuery fromGlobalQuery()
 * @method static ?PostInterface select(int $id)
 * @method static ?PostInterface selectName(string $name)
 * @method static PostCollectionInterface whereIds(int ...$ids)
 * @method static PostCollectionInterface whereNames(string ...$names)
 * @method static PostCollectionInterface whereAuthor(AuthorInterface $author)
 * @method static PostCollectionInterface whereAuthorDrafts(AuthorInterface $author)
 * @method static PostCollectionInterface whereAuthorAll(AuthorInterface $author)
 * @method static PostCollectionInterface whereStatus(PostStatusInterface $status)
 * @method static PostCollectionInterface whereTag(TagInterface $tag)
 * @method static PostCollectionInterface whereCategory(CategoryInterface $category)
 * @method static PostCollectionInterface query(array $args)
 * @method static PostCollectionInterface all()
 * @method static PostInterface make(array $data)
 * @method static void insert(PostInterface $post)
 * @method static void update(PostInterface $post)
 * @method static void trash(int $id)
 * @method static void recover(int $id)
 * @method static void delete(int $id)
 */
class Posts extends _Facade
{
    protected static function _getFacadeAccessor(): string
    {
        return PostRepositoryInterface::class;
    }
}
