<?php

namespace Leonidas\Library\System\Model\User\Profile;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\User\Profile\UserProfileInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class UserProfileGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(UserProfileInterface $user)
    {
        parent::__construct($user, $this->resolvedGetters($user));
    }

    protected function resolvedGetters(UserProfileInterface $user): array
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
