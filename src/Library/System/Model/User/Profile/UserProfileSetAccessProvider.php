<?php

namespace Leonidas\Library\System\Model\User\Profile;

use DateTime;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\System\Model\User\Profile\MutableUserProfileInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\SetAccessProvider;

class UserProfileSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(MutableUserProfileInterface $user)
    {
        parent::__construct($user, $this->resolvedSetters($user));
    }

    protected function resolvedSetters(MutableUserProfileInterface $user): array
    {
        $setDateRegistered = fn ($value) => $user->setDateRegistered(new DateTime($value));
        $setUrl = fn ($value) => $user->setUrl(new WebPage($value));

        return [
            'dateRegistered' => $setDateRegistered,
            'date_registered' => $setDateRegistered,
            'url' => $setUrl,
        ];
    }
}
