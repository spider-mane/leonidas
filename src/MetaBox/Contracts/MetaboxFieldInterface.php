<?php

namespace WebTheory\Leonidas\MetaBox\Contracts;

use WebTheory\Leonidas\MetaBox\Contracts\MetaboxContentInterface;
use WebTheory\Leonidas\Contracts\WpAdminFieldInterface;

interface MetaboxFieldInterface extends MetaboxContentInterface, WpAdminFieldInterface
{
    /**
     *
     */
    public function setRowPadding(int $rowPadding);
}
