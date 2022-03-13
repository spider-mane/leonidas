<?php

namespace Leonidas\Library\Core\Facades;

use Panamax\Traits\ServiceContainerFacadeTrait;
use WebTheory\Facade\MockeryMockableFacadeBaseTrait;

abstract class _Facade
{
    use MockeryMockableFacadeBaseTrait, ServiceContainerFacadeTrait {
        ServiceContainerFacadeTrait::_updateContainer insteadof MockeryMockableFacadeBaseTrait;
    }
}
