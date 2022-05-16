<?php

namespace Leonidas\Contracts\Admin\Component\Table;

use Leonidas\Contracts\Admin\Component\AdminComponentInterface;

interface ColumnRowActionInterface extends AdminComponentInterface
{
    public function getTitle(): string;
}
