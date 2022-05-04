<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\User\MutableUserInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\User\MutableUserModelTrait;
use Leonidas\Library\System\Model\Abstracts\User\ValidatesRoleTrait;
use WP_User;

class User implements MutableUserInterface
{
    use AllAccessGrantedTrait;
    use MutableUserModelTrait;
    use ValidatesRoleTrait;

    public function __construct(WP_User $user)
    {
        $this->user = $user;

        $this->getAccessProvider = new UserGetAccessProvider($this);
        $this->setAccessProvider = new UserSetAccessProvider($this);
    }
}
