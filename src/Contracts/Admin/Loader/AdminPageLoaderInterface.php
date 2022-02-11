<?php

namespace Leonidas\Contracts\Admin\Loader;

use Leonidas\Contracts\Admin\Components\AdminPageCollectionInterface;

interface AdminPageLoaderInterface
{
    public function add(AdminPageCollectionInterface $pages);

    public function remove(AdminPageCollectionInterface $pages);
}
