<?php

namespace WebTheory\Leonidas\Admin\Metabox\Contracts;

use WebTheory\Leonidas\Admin\Metabox\Contracts\MetaboxContentInterface;
use WebTheory\Leonidas\Admin\Contracts\WpAdminFieldInterface;

interface MetaboxFieldInterface extends MetaboxContentInterface, WpAdminFieldInterface
{
    /**
     *
     */
    public function setRowPadding(int $rowPadding);
}
