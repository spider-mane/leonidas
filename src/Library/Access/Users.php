<?php

declare(strict_types=1);

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\User\UserCollectionInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;

/**
 * @method static ?UserInterface select(int $id)
 * @method static ?UserInterface selectNicename(string $slug)
 * @method static ?UserInterface selectEmail(string $email)
 * @method static ?UserInterface selectLogin(string $login)
 * @method static UserCollectionInterface whereIds(int ...$ids)
 * @method static UserCollectionInterface all()
 * @method static void insert(UserInterface $user)
 * @method static void update(UserInterface $user)
 * @method static void delete(int $id)
 */
class Users extends _Facade
{
    protected static function _getFacadeAccessor(): string
    {
        return UserRepositoryInterface::class;
    }
}
