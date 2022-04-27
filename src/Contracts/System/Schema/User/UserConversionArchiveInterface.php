<?php

namespace Leonidas\Contracts\System\Schema\User;

use Leonidas\Contracts\System\Schema\EntityConversionArchiveInterface;
use WP_User;

interface UserConversionArchiveInterface extends EntityConversionArchiveInterface
{
    public function getConversion(WP_User $post): object;

    public function getReversion(object $entity): WP_User;

    public function archive(WP_User $native, object $conversion): void;
}
