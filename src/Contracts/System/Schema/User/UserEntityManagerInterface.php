<?php

namespace Leonidas\Contracts\System\Schema\User;

use Leonidas\Contracts\System\Schema\EntityManagerInterface;

interface UserEntityManagerInterface extends EntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function whereIds(int ...$ids): object;

    public function selectByLogin(string $login): object;

    public function selectByEmail(string $email): object;

    public function selectByNicename(string $nicename): object;

    public function whereBlogId(int $blogId): object;
}
