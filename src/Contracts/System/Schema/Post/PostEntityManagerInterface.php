<?php

namespace Leonidas\Contracts\System\Schema\Post;

use Leonidas\Contracts\System\Schema\SoftDeletingEntityManagerInterface;

interface PostEntityManagerInterface extends SoftDeletingEntityManagerInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function whereIds(int ...$ids): object;

    public function selectByName(string $name): object;

    public function whereNames(string ...$names): object;

    public function whereUser(int $user): object;

    public function whereUserAndStatus(int $user, string $status): object;

    public function whereParentId(int $parentId): object;

    public function whereStatus(string $status): object;

    public function whereTaxQuery(array $args): object;

    public function withTerm(string $taxonomy, int $termId): object;
}
