<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\ModelConfigurationBuilderInterface;

interface PostTypeBuilderInterface extends ModelConfigurationBuilderInterface
{
    /**
     * @param list<string> $taxonomies
     *
     * @return $this
     */
    public function taxonomies(?array $taxonomies): static;

    /**
     * @return $this
     */
    public function capabilityType(null|string|array $capabilityType): static;

    /**
     * @return $this
     */
    public function canExport(?bool $canExport): static;

    /**
     * @return $this
     */
    public function deleteWithUser(?bool $deleteWithUser): static;

    /**
     * @return $this
     */
    public function mapMetaCap(?bool $mapMetaCap): static;

    /**
     * @return $this
     */
    public function hasArchive(null|bool|string $archive): static;

    /**
     * @return $this
     */
    public function excludeFromSearch(?bool $excludeFromSearch): static;

    /**
     * @return $this
     */
    public function showInMenu(null|bool|string $showInMenu): static;

    /**
     * @return $this
     */
    public function showInAdminBar(?bool $showInAdminBar): static;

    /**
     * @return $this
     */
    public function menuPosition(?int $menuPosition): static;

    /**
     * @return $this
     */
    public function menuIcon(?string $menuIcon): static;

    /**
     * @return $this
     */
    public function supports(null|bool|array $supports): static;

    /**
     * @return $this
     */
    public function registerMetaBoxCb(?callable $registerMetaBoxCb): static;

    /**
     * @return $this
     */
    public function template(?array $template): static;

    /**
     * @return $this
     */
    public function templateLock(null|false|string $templateLock): static;

    /**
     * @return $this
     */
    public function autosaveRestControllerClass(null|bool|string $autosaveRestControllerClass): static;

    /**
     * @return $this
     */
    public function revisionsRestControllerClass(null|bool|string $revisionsRestControllerClass): static;

    /**
     * @return $this
     */
    public function allowsLateRouteRegistration(?bool $allowsLateRouteRegistration): static;

    public function get(): PostTypeInterface;
}
