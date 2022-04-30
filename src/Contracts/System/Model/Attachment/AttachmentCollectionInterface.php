<?php

namespace Leonidas\Contracts\System\Model\Attachment;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface AttachmentCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): AttachmentInterface;
}
