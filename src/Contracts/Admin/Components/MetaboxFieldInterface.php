<?php

namespace Leonidas\Contracts\Admin\Components;

interface MetaboxFieldInterface extends MetaboxComponentInterface, AdminFieldInterface
{
    public function setRowPadding(int $rowPadding);
}
