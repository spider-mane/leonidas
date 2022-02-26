<?php

namespace Leonidas\Contracts\Admin\Components;

use Leonidas\Contracts\Admin\Components\FlexPageInterface;

interface FlexPageLoaderInterface
{
    public function addOne(FlexPageInterface $page);
}
