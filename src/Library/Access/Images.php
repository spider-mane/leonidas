<?php

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\Image\ImageCollectionInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Contracts\System\Model\Image\ImageRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Image\ImageQuery;
use Leonidas\Library\System\Model\Image\ImageQueryFactory;

/**
 * @method static ?ImageInterface select(int $id)
 * @method static ImageCollectionInterface whereIds(int ...$ids)
 * @method static ImageCollectionInterface whereAttachedToPost(PostInterface $post)
 * @method static ImageCollectionInterface query(array $args)
 * @method static ImageCollectionInterface all()
 * @method static void insert(ImageInterface $image)
 * @method static void update(ImageInterface $image)
 * @method static void delete(int $id)
 * @method static void trash(int $id)
 * @method static void recover(int $id)
 */
class Images extends _Facade
{
    public static function fromQuery(): ImageQuery
    {
        return static::getQueryFactory()->createQuery($GLOBALS['wp_query']);
    }

    protected static function getQueryFactory(): ImageQueryFactory
    {
        return static::$container->get(ImageQueryFactory::class);
    }

    protected static function _getFacadeAccessor()
    {
        return ImageRepositoryInterface::class;
    }
}
