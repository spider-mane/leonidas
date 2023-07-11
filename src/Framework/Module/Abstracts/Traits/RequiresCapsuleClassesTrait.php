<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

trait RequiresCapsuleClassesTrait
{
    /**
     * @return list<class-string>
     */
    abstract protected function capsuleClasses(): array;
}
