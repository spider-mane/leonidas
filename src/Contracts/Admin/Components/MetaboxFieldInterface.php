<?php

namespace WebTheory\Leonidas\Contracts\Admin\Components;

use WebTheory\Leonidas\Admin\Contracts\MetaboxComponentInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminFieldInterface;

interface MetaboxFieldInterface extends MetaboxComponentInterface, AdminFieldInterface
{
    /**
     *
     */
    public function setRowPadding(int $rowPadding);
}
