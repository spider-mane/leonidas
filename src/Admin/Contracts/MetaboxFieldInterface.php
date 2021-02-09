<?php

namespace WebTheory\Leonidas\Admin\Contracts;

use WebTheory\Leonidas\Admin\Contracts\MetaboxComponentInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminFieldInterface;

interface MetaboxFieldInterface extends MetaboxComponentInterface, AdminFieldInterface
{
    /**
     *
     */
    public function setRowPadding(int $rowPadding);
}
