<?php

namespace Leonidas\Library\System\Configuration\Option;

use Leonidas\Contracts\Option\OptionRepositoryInterface;

class DeferredOptionValueFactory
{
    public function __construct(protected OptionRepositoryInterface $repository)
    {
        //
    }

    public function get(string $option, mixed $default = null): DeferredOptionValue
    {
        return new DeferredOptionValue($this->repository, $option, $default);
    }
}
