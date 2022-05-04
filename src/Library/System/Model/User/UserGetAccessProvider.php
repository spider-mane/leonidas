<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class UserGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(UserInterface $user)
    {
        parent::__construct($user, $this->resolvedGetters($user));
    }

    protected function resolvedGetters(UserInterface $user): array
    {
        $dateFormat = UserEntityManagerInterface::DATE_FORMAT;

        $getDateRegistered = fn () => $user->getDateRegistered()->format($dateFormat);
        $getUrl = fn () => $user->getUrl()->getHref();

        return [
            'dateRegistered' => $getDateRegistered,
            'date_registered' => $getDateRegistered,
            'url' => $getUrl,
        ];
    }
}
