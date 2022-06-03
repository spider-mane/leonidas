<?php

namespace Leonidas\Contracts\Admin\Component;

interface FieldContainerInterface extends AdminComponentInterface
{
    /**
     * @return array<int,string|AdminFieldInterface>
     */
    public function getFields(): array;
}
