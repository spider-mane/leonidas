<?php

namespace Leonidas\Contracts\System\Model\PostType;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeBuilderInterface;

interface PostTypeBuilderInterface extends BaseSystemModelTypeBuilderInterface
{
    public function excludeFromSearch(?bool $excludeFromSearch): self;

    public function showInAdminBar(?bool $showInAdminBar): self;

    public function menuPosition(?int $menuPosition): self;

    public function menuIcon(?string $menuIcon): self;

    /**
     * @param null|string|array $capabilityType
     */
    public function capabilityType($capabilityType): self;

    public function mapMetaCap(?bool $mapMetaCap): self;

    /**
     * @param null|bool|array $supports
     */
    public function supports($supports): self;

    public function registerMetaBoxCb(?callable $registerMetaBoxCb): self;

    public function taxonomies(?array $taxonomies): self;

    /**
     * @param null|bool|string $archive
     */
    public function hasArchive(?bool $archive): self;

    public function canExport(?bool $canExport): self;

    public function deleteWithUser(?bool $deleteWithUser): self;

    public function template(?array $template): self;

    /**
     * @param null|false|string $templateLock
     */
    public function templateLock($templateLock): self;

    public function get(): PostTypeInterface;
}
