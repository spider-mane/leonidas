<?php

namespace Leonidas\Library\System\Configuration\PostType;

use Closure;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeBuilderInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractModelConfigurationBuilder;

class PostTypeBuilder extends AbstractModelConfigurationBuilder implements PostTypeBuilderInterface
{
    protected ?array $taxonomies = null;

    protected null|string|array $capabilityType = null;

    protected ?bool $mapMetaCap = null;

    protected ?bool $canExport = null;

    protected ?bool $deleteWithUser = null;

    protected null|bool|string $archive = null;

    protected ?bool $excludeFromSearch = null;

    protected null|string|bool $autosaveRestControllerClass = null;

    protected null|string|bool $revisionsRestControllerClass = null;

    protected null|bool $allowsLateRouteRegistration = null;

    protected ?bool $showInAdminBar = null;

    protected null|bool|string $showInMenu = null;

    protected ?int $menuPosition = null;

    protected ?string $menuIcon = null;

    protected null|bool|array $supports = null;

    /**
     * @var null|callable
     */
    protected null|string|array|Closure $registerMetaBoxCb = null;

    protected ?array $template = null;

    protected null|false|string $templateLock = null;

    public function taxonomies(?array $taxonomies): static
    {
        $this->taxonomies = $taxonomies;

        return $this;
    }

    public function capabilityType(null|string|array $capabilityType): static
    {
        $this->capabilityType = $capabilityType;

        return $this;
    }

    public function mapMetaCap(?bool $mapMetaCap): static
    {
        $this->mapMetaCap = $mapMetaCap;

        return $this;
    }

    public function canExport(?bool $canExport): static
    {
        $this->canExport = $canExport;

        return $this;
    }

    public function deleteWithUser(?bool $deleteWithUser): static
    {
        $this->deleteWithUser = $deleteWithUser;

        return $this;
    }

    public function hasArchive(null|bool|string $archive): static
    {
        $this->archive = $archive;

        return $this;
    }

    public function excludeFromSearch(?bool $excludeFromSearch): static
    {
        $this->excludeFromSearch = $excludeFromSearch;

        return $this;
    }

    public function autosaveRestControllerClass(null|bool|string $autosaveRestControllerClass): static
    {
        $this->autosaveRestControllerClass = $autosaveRestControllerClass;

        return $this;
    }

    public function revisionsRestControllerClass(null|bool|string $revisionsRestControllerClass): static
    {
        $this->revisionsRestControllerClass = $revisionsRestControllerClass;

        return $this;
    }

    public function allowsLateRouteRegistration(?bool $allowsLateRouteRegistration): static
    {
        $this->allowsLateRouteRegistration = $allowsLateRouteRegistration;

        return $this;
    }

    public function showInMenu(null|bool|string $showInMenu): static
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    public function showInAdminBar(?bool $showInAdminBar): static
    {
        $this->showInAdminBar = $showInAdminBar;

        return $this;
    }

    public function menuPosition(?int $menuPosition): static
    {
        $this->menuPosition = $menuPosition;

        return $this;
    }

    public function menuIcon(?string $menuIcon): static
    {
        $this->menuIcon = $menuIcon;

        return $this;
    }

    public function supports(null|bool|array $supports): static
    {
        $this->supports = $supports;

        return $this;
    }

    public function registerMetaBoxCb(?callable $registerMetaBoxCb): static
    {
        $this->registerMetaBoxCb = $registerMetaBoxCb;

        return $this;
    }

    public function template(?array $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function templateLock(null|false|string $templateLock): static
    {
        $this->templateLock = $templateLock;

        return $this;
    }

    public function get(): PostType
    {
        return new PostType(
            $this->name,
            $this->pluralLabel,
            $this->singularLabel,
            $this->description,
            $this->labels,
            $this->isPublic,
            $this->hierarchical,
            $this->publiclyQueryable,
            $this->isAllowedInUi,
            $this->displayedInMenu,
            $this->isAllowedInNavMenus,
            $this->capabilities,
            $this->rewrite,
            $this->queryVar,
            $this->isAllowedInRest,
            $this->restBase,
            $this->restNamespace,
            $this->restControllerClass,
            $this->autosaveRestControllerClass,
            $this->revisionsRestControllerClass,
            $this->allowsLateRouteRegistration,
            $this->excludeFromSearch,
            $this->showInAdminBar,
            $this->menuPosition,
            $this->menuIcon,
            $this->capabilityType,
            $this->mapMetaCap,
            $this->supports,
            $this->registerMetaBoxCb,
            $this->taxonomies,
            $this->archive,
            $this->canExport,
            $this->deleteWithUser,
            $this->template,
            $this->templateLock,
            $this->extra
        );
    }

    public static function for(string $name): static
    {
        return new static($name);
    }
}
