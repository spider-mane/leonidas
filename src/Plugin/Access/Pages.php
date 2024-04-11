<?php

declare(strict_types=1);

namespace Leonidas\Plugin\Access;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Library\System\Model\Page\PageQuery;

/**
 * @method static PageQuery fromGlobalQuery()
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
 * @method static void trash(int $id)
 * @method static void recover(int $id)
 * @method static void delete(int $id)
 */
class Pages extends _Facade
{
    protected static function _getFacadeAccessor(): string
    {
        return PageRepositoryInterface::class;
    }
}
