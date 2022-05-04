<?php

namespace Leonidas\Library\System\Model\User;

use Carbon\Carbon;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\System\Model\User\MutableUserInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\SetAccessProvider;

class UserSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(MutableUserInterface $user)
    {
        parent::__construct($user, $this->resolvedSetters($user));
    }

    protected function resolvedSetters(MutableUserInterface $user): array
    {
        $setDateRegistered = fn ($value) => $user->setDateRegistered(new Carbon($value));
        $setUrl = fn ($value) => $user->setUrl(new WebPage($value));

        return [
            'dateRegistered' => $setDateRegistered,
            'date_registered' => $setDateRegistered,
            'url' => $setUrl,
        ];
    }
}
