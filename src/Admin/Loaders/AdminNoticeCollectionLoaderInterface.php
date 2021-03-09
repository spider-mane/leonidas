<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use WebTheory\Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use WebTheory\Leonidas\Contracts\Admin\ComponentLoaderInterface;

interface AdminNoticeCollectionLoaderInterface extends ComponentLoaderInterface
{
    public function addNotice(AdminNoticeInterface $adminNotice);
}
