<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\User\MutableUserInterface;
use Leonidas\Contracts\System\Model\User\Profile\UserProfileInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\User\MutableUserModelTrait;
use Leonidas\Library\System\Model\User\Profile\UserProfile;
use WP_User;

class User implements MutableUserInterface
{
    use AllAccessGrantedTrait;
    use MutableUserModelTrait;

    protected UserProfileInterface $profile;

    public function __construct(WP_User $user, ?UserProfileInterface $profile = null)
    {
        $this->user = $user;
        $this->profile = $profile;

        $this->getAccessProvider = new UserGetAccessProvider($this);
        $this->setAccessProvider = new UserSetAccessProvider($this);
    }

    public function getProfile(): UserProfileInterface
    {
        return $this->profile ??= new UserProfile($this->user, $this);
    }

    public function setProfile(UserProfileInterface $profile): self
    {
        return $this->assignProfileToUser($profile);
    }
}
