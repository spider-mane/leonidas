<?php

namespace Backalley\WordPress\MetaBox\Contracts;

use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;
use Backalley\WordPress\Contracts\WpAdminFieldInterface;

interface MetaboxFieldInterface extends MetaboxContentInterface, WpAdminFieldInterface
{
    /**
     *
     */
    public function setRowPadding(int $rowPadding);
}
