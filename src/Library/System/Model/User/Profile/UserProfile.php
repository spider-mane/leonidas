<?php

namespace Leonidas\Library\System\Model\User\Profile;

use Leonidas\Contracts\System\Model\User\Profile\MutableUserProfileInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\User\MutableProfileTrait;
use Leonidas\Library\System\Model\User\User;
use WP_User;

class UserProfile implements MutableUserProfileInterface
{
    use AllAccessGrantedTrait;
    use MutableProfileTrait;

    protected UserInterface $owner;

    public function __construct(WP_User $user, ?UserInterface $owner = null)
    {
        $this->user = $user;
        $this->owner = $owner;

        $this->getAccessProvider = new UserProfileGetAccessProvider($this);
        $this->setAccessProvider = new UserProfileSetAccessProvider($this);
    }

    public function getUser(): UserInterface
    {
        return $this->owner ??= new User($this->user, $this);
    }

    public function setUser(UserInterface $user): self
    {
        $this->owner = $user;

        return $this;
    }
}
