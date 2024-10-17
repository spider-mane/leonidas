<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\ModelPublicConfigInterface;

interface PostTypePublicConfigInterface extends ModelPublicConfigInterface
{
    public function isExcludedFromSearch(): ?bool;

    public function getArchive(): null|bool|string;
}
