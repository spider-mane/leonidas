<?php

namespace Leonidas\Contracts\System\Model\Author\Profile;

use Leonidas\Contracts\System\Model\ProfileInterface;
use Leonidas\Contracts\System\Model\User\Profile\UserProfileInterface;

interface AuthorProfileInterface extends ProfileInterface
{
    public function getAuthor(): UserProfileInterface;

    public function setAuthor(UserProfileInterface $author): self;
}
