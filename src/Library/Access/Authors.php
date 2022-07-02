<?php

declare(strict_types=1);

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\Author\AuthorCollectionInterface;
use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;

/**
 * @method static ?AuthorInterface select(int $id)
 * @method static ?AuthorInterface selectNicename(string $slug)
 * @method static ?AuthorInterface selectEmail(string $email)
 * @method static ?AuthorInterface selectLogin(string $login)
 * @method static AuthorCollectionInterface whereIds(int ...$ids)
 * @method static AuthorCollectionInterface all()
 * @method static void insert(AuthorInterface $user)
 * @method static void update(AuthorInterface $user)
 * @method static void delete(int $id)
 */
class Authors extends _Facade
{
    protected static function _getFacadeAccessor(): string
    {
        return AuthorRepositoryInterface::class;
    }
}
