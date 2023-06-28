<?php

namespace Leonidas\Library\System\Schema\User;

use Leonidas\Contracts\System\Schema\User\UserConversionArchiveInterface;
use Leonidas\Library\System\Schema\Abstracts\AbstractEntityConversionArchive;
use WP_User;

class UserConversionArchive extends AbstractEntityConversionArchive implements UserConversionArchiveInterface
{
    protected array $conversions = [];

    protected array $reversions = [];

    public function getConversion(WP_User $user): object
    {
        return $this->conversions[$this->hash($user)];
    }

    public function getReversion(object $entity): WP_User
    {
        return $this->reversions[$this->hash($entity)];
    }

    public function archive(WP_User $user, object $entity): void
    {
        $this->reversions[$this->hash($entity)] = $user;
        $this->conversions[$this->hash($user)] = $entity;
    }
}
