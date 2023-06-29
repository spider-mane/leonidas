<?php

declare(strict_types=1);

namespace Leonidas\Plugin\Access;

use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\PostModelInterface;

/**
 * @method static ?CommentInterface select(int $id)
 * @method static CommentCollectionInterface whereApprovedOnPost(PostModelInterface $post)
 * @method static CommentCollectionInterface whereIds(int ...$ids)
 * @method static CommentCollectionInterface whereParent(CommentInterface $comment)
 * @method static ?CommentInterface whereChild(CommentInterface $comment)
 * @method static CommentCollectionInterface all()
 * @method static void insert(CommentInterface $comment)
 * @method static void update(CommentInterface $comment)
 * @method static void delete(int $id)
 */
class Comments extends _Facade
{
    protected static function _getFacadeAccessor(): string
    {
        return CommentRepositoryInterface::class;
    }
}
