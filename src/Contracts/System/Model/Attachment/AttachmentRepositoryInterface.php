<?php

namespace Leonidas\Contracts\System\Model\Attachment;

interface AttachmentRepositoryInterface
{
    public function select(int $id): AttachmentInterface;
}
