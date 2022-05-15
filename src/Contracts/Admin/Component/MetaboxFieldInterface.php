<?php

namespace Leonidas\Contracts\Admin\Component;

interface MetaboxFieldInterface extends MetaboxComponentInterface, AdminFieldInterface
{
    public function setRowPadding(int $rowPadding);
}
