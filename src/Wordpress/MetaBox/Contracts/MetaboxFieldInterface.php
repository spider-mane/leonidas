<?php

namespace WebTheory\WordPress\MetaBox\Contracts;

use WebTheory\WordPress\MetaBox\Contracts\MetaboxContentInterface;
use WebTheory\WordPress\Contracts\WpAdminFieldInterface;

interface MetaboxFieldInterface extends MetaboxContentInterface, WpAdminFieldInterface
{
    /**
     *
     */
    public function setRowPadding(int $rowPadding);
}
