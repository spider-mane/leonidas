<?php

namespace Leonidas\Contracts\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\AdminFieldInterface;

interface MetaboxFieldInterface extends MetaboxComponentInterface, AdminFieldInterface
{
    public function setRowPadding(int $rowPadding);
}
