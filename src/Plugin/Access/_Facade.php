<?php

namespace Leonidas\Plugin\Access;

use Panamax\Traits\ServiceContainerFacadeTrait;
use WebTheory\Facade\Interfaces\FacadeInterface;
use WebTheory\Facade\MockeryMockableFacadeBaseTrait;

abstract class _Facade implements FacadeInterface
{
    use MockeryMockableFacadeBaseTrait, ServiceContainerFacadeTrait {
        ServiceContainerFacadeTrait::_updateContainer insteadof MockeryMockableFacadeBaseTrait;
    }
}
