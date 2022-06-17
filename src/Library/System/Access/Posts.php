<?php

namespace Leonidas\Library\System\Access;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Library\Core\Access\_Facade;
use Leonidas\Library\System\Model\Post\PostQuery;
use Leonidas\Library\System\Model\Post\PostQueryFactory;

/**
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
 * @method static void delete(int $id)
 * @method static void trash(int $id)
 * @method static void recover(int $id)
 */
class Posts extends _Facade
{
    public static function fromQuery(): PostQuery
    {
        return static::getQueryFactory()->createQuery($GLOBALS['wp_query']);
    }

    protected static function getQueryFactory(): PostQueryFactory
    {
        return static::$container->get(PostQueryFactory::class);
    }

    protected static function _getFacadeAccessor()
    {
        return PostRepositoryInterface::class;
    }
}
