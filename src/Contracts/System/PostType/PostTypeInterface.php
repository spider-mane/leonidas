<?php

namespace Leonidas\Contracts\System\PostType;

use Leonidas\Contracts\System\BaseSystemModelTypeInterface;

interface PostTypeInterface extends BaseSystemModelTypeInterface
{
    public function isExcludedFromSearch(): bool;

    public function isAllowedInAdminBar(): bool;

    public function getMenuPosition(): ?int;

    public function getMenuIcon(): ?string;

    /**
     * @return string|array
     */
    public function getCapabilityType();

    public function allowsMetaCapMapping(): bool;

    /**
     * @return array|bool
     */
    public function getSupports();

    public function getRegisterMetaBoxCb(): ?callable;

    public function getTaxonomies(): array;

    /**
     * @return bool|string
     */
    public function getArchive();

    public function canBeExported(): bool;

    public function isDeletedWithUser(): ?bool;

    public function getTemplate(): array;

    /**
     * @return false|string
     */
    public function getTemplateLock();
}
