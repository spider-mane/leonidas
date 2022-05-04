<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Leonidas\Contracts\System\Model\SetAccessProviderInterface;

trait SetAccessGrantedTrait
{
    protected SetAccessProviderInterface $setAccessProvider;

    public function __set(string $name, $value): void
    {
        $this->setAccessProvider->set($name, $value);
    }
}
