<?php

namespace Leonidas\Contracts\System\Model\Attachment;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface AttachmentCollectionInterface extends SystemModelCollectionInterface
{
    public function getById(int $id): AttachmentInterface;
}
