<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface AdminNoticeCollectionLoaderInterface extends ComponentLoaderInterface
{
    public function addNotice(AdminNoticeInterface $adminNotice);
}
