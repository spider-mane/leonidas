<?php

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class AuthorGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(AuthorInterface $author)
    {
        parent::__construct($author, $this->resolvedGetters($author));
    }

    protected function resolvedGetters(AuthorInterface $author): array
    {
        $dateFormat = UserEntityManagerInterface::DATE_FORMAT;

        $getDateRegistered = fn () => $author->getDateRegistered()->format($dateFormat);
        $getUrl = fn () => $author->getUrl()->getHref();

        return [
            'dateRegistered' => $getDateRegistered,
            'date_registered' => $getDateRegistered,
            'url' => $getUrl,
        ];
    }
}
