<?php

namespace Leonidas\Library\System\Configuration\Option;

use Leonidas\Contracts\Option\OptionRepositoryInterface;
use WebTheory\Config\Interfaces\ConfigInterface;
use WebTheory\Config\Interfaces\DeferredValueInterface;

class DeferredOptionValue implements DeferredValueInterface
{
    public function __construct(
        protected OptionRepositoryInterface $repository,
        protected string $option,
        protected mixed $default = null
    ) {
        //
    }

    public function resolve(ConfigInterface $config): mixed
    {
        return $this->repository->get($this->option, $this->default);
    }
}
