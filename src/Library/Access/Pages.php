<?php

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Library\System\Model\Page\PageQuery;
use Leonidas\Library\System\Model\Page\PageQueryFactory;

/**
 * @method static ?PageInterface select(int $id)
 * @method static PageCollectionInterface whereIds(int ...$ids)
 * @method static ?PageInterface selectName(string $name)
 * @method static PageCollectionInterface whereNames(string ...$names)
 * @method static PageCollectionInterface whereParent(?PageInterface $parent)
 * @method static PageCollectionInterface whereParentId(int $parentId)
 * @method static PageCollectionInterface query(array $args)
 * @method static PageCollectionInterface all()
 * @method static void insert(PageInterface $post)
 * @method static void update(PageInterface $post)
 * @method static void delete(int $id)
 * @method static void trash(int $id)
 * @method static void recover(int $id)
 */
class Pages extends _Facade
{
    public static function fromQuery(): PageQuery
    {
        return static::getQueryFactory()->createQuery($GLOBALS['wp_query']);
    }

    protected static function getQueryFactory(): PageQueryFactory
    {
        return static::$container->get(PageQueryFactory::class);
    }

    protected static function _getFacadeAccessor()
    {
        return PageRepositoryInterface::class;
    }
}
