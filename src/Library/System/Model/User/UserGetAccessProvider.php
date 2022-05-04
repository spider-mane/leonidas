<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class UserGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(UserInterface $user)
    {
        parent::__construct($user, $this->resolvedGetters($user));
    }

    protected function resolvedGetters(UserInterface $user): array
    {
        return [];
    }
}
