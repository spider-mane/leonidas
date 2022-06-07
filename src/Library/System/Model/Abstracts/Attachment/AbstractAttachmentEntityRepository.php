<?php

namespace Leonidas\Library\System\Model\Abstracts\Attachment;

use Leonidas\Contracts\System\Schema\Post\AttachmentEntityManagerInterface;

abstract class AbstractAttachmentEntityRepository
{
    protected AttachmentEntityManagerInterface $manager;

    public function __construct(AttachmentEntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function delete(int $pageId): void
    {
        $this->manager->delete($pageId);
    }

    public function trash(int $pageId): void
    {
        $this->manager->trash($pageId);
    }

    public function recover(int $pageId): void
    {
        $this->manager->recover($pageId);
    }
}
