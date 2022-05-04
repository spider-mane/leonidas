<?php

namespace Leonidas\Library\System\Model\Author;

use Carbon\Carbon;
use Leonidas\Contracts\System\Model\Author\MutableAuthorInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\SetAccessProvider;

class AuthorSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(MutableAuthorInterface $author)
    {
        parent::__construct($author, $this->resolvedSetters($author));
    }

    protected function resolvedSetters(MutableAuthorInterface $author): array
    {
        $setDateRegistered = fn ($value) => $author->setDateRegistered(new Carbon($value));
        $setUrl = fn ($value) => $author->setUrl(new WebPage($value));

        return [
            'dateRegistered' => $setDateRegistered,
            'date_registered' => $setDateRegistered,
            'url' => $setUrl,
        ];
    }
}
