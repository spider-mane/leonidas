<?php

namespace Leonidas\Contracts\System\Schema\User;

use Leonidas\Contracts\System\Schema\EntityManagerInterface;

interface UserEntityManagerInterface extends EntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function byLogin(string $login): ?object;

    public function byEmail(string $email): ?object;

    public function byNicename(string $nicename): ?object;

    public function whereNicenames(string ...$nicenames): object;

    public function whereBlogId(int $blogId): object;

    public function whereRoles(string ...$roles): object;

    public function whereAuthoredPostEntities(string ...$postTypes): object;

    public function byPost(int $postId): ?object;
}
