<?php

namespace Backalley\Wordpress\MetaBox\Contracts;

use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;
use Backalley\Wordpress\Contracts\WpAdminFieldInterface;

interface MetaboxFieldInterface extends MetaboxContentInterface, WpAdminFieldInterface
{
    /**
     *
     */
    public function setRowPadding(int $rowPadding);
}
