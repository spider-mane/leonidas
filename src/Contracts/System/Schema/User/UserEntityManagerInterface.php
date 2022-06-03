<?php

namespace Leonidas\Contracts\System\Schema\User;

use Leonidas\Contracts\System\Schema\EntityManagerInterface;

interface UserEntityManagerInterface extends EntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function selectLogin(string $login): ?object;

    public function selectEmail(string $email): ?object;

    public function selectNicename(string $nicename): ?object;

    public function whereBlogId(int $blogId): object;
}
