<?php

namespace Leonidas\Library\Admin\Loaders;

use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use Leonidas\Contracts\Admin\ComponentLoaderInterface;

interface AdminNoticeCollectionLoaderInterface extends ComponentLoaderInterface
{
    public function addNotice(AdminNoticeInterface $adminNotice);
}
