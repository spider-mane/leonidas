<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\ModelCoreConfigInterface;

interface PostTypeCoreConfigInterface extends ModelCoreConfigInterface
{
    public function getTaxonomies(): ?array;

    public function getCapabilityType(): null|string|array;

    public function allowsMetaCapMapping(): ?bool;

    public function canBeExported(): ?bool;

    public function isDeletedWithUser(): ?bool;
}
