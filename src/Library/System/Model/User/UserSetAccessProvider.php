<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\SetAccessProvider;

class UserSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(UserInterface $user)
    {
        parent::__construct($user, $this->resolvedSetters($user));
    }

    protected function resolvedSetters(UserInterface $user): array
    {
        return [];
    }
}
