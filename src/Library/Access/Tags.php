<?php

declare(strict_types=1);

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;

/**
 * @method static ?TagInterface select(int $id)
 * @method static ?TagInterface selectSlug(string $slug)
 * @method static TagCollectionInterface whereIds(int ...$ids)
 * @method static TagCollectionInterface whereObjectId(int $id)
 * @method static TagCollectionInterface wherePost(PostInterface $post)
 * @method static TagCollectionInterface all()
 * @method static void insert(TagInterface $tag)
 * @method static void update(TagInterface $tag)
 * @method static void delete(int $id)
 */
class Tags extends _Facade
{
    protected static function _getFacadeAccessor(): string
    {
        return TagRepositoryInterface::class;
    }
}
