<?php

namespace WebTheory\Leonidas\Contracts\Admin\Components;

interface MetaboxFieldInterface extends MetaboxComponentInterface, AdminFieldInterface
{
    /**
     *
     */
    public function setRowPadding(int $rowPadding);
}
