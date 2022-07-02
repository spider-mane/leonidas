<?php

declare(strict_types=1);

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;

/**
 * @method static ?CategoryInterface select(int $id)
 * @method static ?CategoryInterface selectSlug(string $slug)
 * @method static CategoryCollectionInterface whereIds(int ...$ids)
 * @method static CategoryCollectionInterface whereObjectId(int $id)
 * @method static CategoryCollectionInterface wherePost(PostInterface $post)
 * @method static CategoryCollectionInterface whereParent(CategoryInterface $parent)
 * @method static CategoryCollectionInterface all()
 * @method static void insert(CategoryInterface $category)
 * @method static void update(CategoryInterface $category)
 * @method static void delete(int $id)
 */
class Categories extends _Facade
{
    protected static function _getFacadeAccessor(): string
    {
        return CategoryRepositoryInterface::class;
    }
}
