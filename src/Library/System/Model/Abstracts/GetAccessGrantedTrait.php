<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use ReturnTypeWillChange;

trait GetAccessGrantedTrait
{
    protected GetAccessProviderInterface $getAccessProvider;

    #[ReturnTypeWillChange]
    public function __get(string $name)
    {
        return $this->getAccessProvider->get($name);
    }
}
