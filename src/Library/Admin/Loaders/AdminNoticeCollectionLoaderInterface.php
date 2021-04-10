<?php

namespace Leonidas\Library\Admin\Loaders;

use Leonidas\Contracts\Admin\ComponentLoaderInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;

interface AdminNoticeCollectionLoaderInterface extends ComponentLoaderInterface
{
    public function addNotice(AdminNoticeInterface $adminNotice);
}
