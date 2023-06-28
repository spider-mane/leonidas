<?php

namespace Leonidas\Library\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\PostType\PostTypeBuilderInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractSystemModelTypeBuilder;

class PostTypeBuilder extends AbstractSystemModelTypeBuilder implements PostTypeBuilderInterface
{
    protected ?bool $excludeFromSearch;

    protected ?bool $showInAdminBar;

    protected ?bool $showInMenu;

    protected ?int $menuPosition;

    protected ?string $menuIcon;

    /**
     * @var null|string|array
     */
    protected $capabilityType;

    protected ?bool $mapMetaCap;

    /**
     * @var null|bool|array
     */
    protected $supports;

    /**
     * @var null|callable
     */
    protected $registerMetaBoxCb;

    protected ?array $taxonomies;

    /**
     * @var null|bool|string
     */
    protected $archive;

    protected ?bool $canExport;

    protected ?bool $deleteWithUser;

    protected ?array $template;

    /**
     * @var null|false|string
     */
    protected $templateLock;

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function plural(string $pluralLabel): self
    {
        $this->pluralLabel = $pluralLabel;

        return $this;
    }

    public function singular(?string $singularLabel): self
    {
        $this->singularLabel = $singularLabel;

        return $this;
    }

    public function description(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function labels(?array $labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    public function public(?bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function hierarchical(?bool $hierarchical): self
    {
        $this->hierarchical = $hierarchical;

        return $this;
    }

    public function publiclyQueryable(?bool $publiclyQueryable): self
    {
        $this->publiclyQueryable = $publiclyQueryable;

        return $this;
    }

    public function showInUi(?bool $showInUi): self
    {
        $this->isAllowedInUi = $showInUi;

        return $this;
    }

    public function showInMenu($showInMenu): self
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    public function showInNavMenus(?bool $showInNavMenu): self
    {
        $this->displayedInMenu = $showInNavMenu;

        return $this;
    }

    public function capabilities(?array $capabilities): self
    {
        $this->capabilities = $capabilities;

        return $this;
    }

    public function rewrite($rewrite): self
    {
        $this->rewrite = $rewrite;

        return $this;
    }

    public function queryVar($queryVar): self
    {
        $this->queryVar = $queryVar;

        return $this;
    }

    public function showInRest(?bool $showInRest): self
    {
        $this->isAllowedInRest = $showInRest;

        return $this;
    }

    public function restBase($restBase): self
    {
        $this->restBase = $restBase;

        return $this;
    }

    public function restNamespace($restNamespace): self
    {
        $this->restNamespace = $restNamespace;

        return $this;
    }

    public function restControllerClass($restControllerClass): self
    {
        $this->restControllerClass = $restControllerClass;

        return $this;
    }

    public function options(?array $extraArgs): self
    {
        $this->options = $extraArgs;

        return $this;
    }

    public function excludeFromSearch(?bool $excludeFromSearch): self
    {
        $this->excludeFromSearch = $excludeFromSearch;

        return $this;
    }

    public function showInAdminBar(?bool $showInAdminBar): self
    {
        $this->showInAdminBar = $showInAdminBar;

        return $this;
    }

    public function menuPosition(?int $menuPosition): self
    {
        $this->menuPosition = $menuPosition;

        return $this;
    }

    public function menuIcon(?string $menuIcon): self
    {
        $this->menuIcon = $menuIcon;

        return $this;
    }

    public function capabilityType($capabilityType): self
    {
        $this->capabilityType = $capabilityType;

        return $this;
    }

    public function mapMetaCap(?bool $mapMetaCap): self
    {
        $this->mapMetaCap = $mapMetaCap;

        return $this;
    }

    public function supports($supports): self
    {
        $this->supports = $supports;

        return $this;
    }

    public function registerMetaBoxCb(?callable $registerMetaBoxCb): self
    {
        $this->registerMetaBoxCb = $registerMetaBoxCb;

        return $this;
    }

    public function taxonomies(?array $taxonomies): self
    {
        $this->taxonomies = $taxonomies;

        return $this;
    }

    public function hasArchive($archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function canExport(?bool $canExport): self
    {
        $this->canExport = $canExport;

        return $this;
    }

    public function deleteWithUser(?bool $deleteWithUser): self
    {
        $this->deleteWithUser = $deleteWithUser;

        return $this;
    }

    public function template(?array $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function templateLock($templateLock): self
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
            $this->description ?? '',
            $this->labels ?? [],
            $this->isPublic ?? false,
            $this->hierarchical ?? false,
            $this->publiclyQueryable,
            $this->isAllowedInUi,
            $this->displayedInMenu,
            $this->isAllowedInNavMenus,
            $this->capabilities ?? [],
            $this->rewrite ?? true,
            $this->queryVar ?? true,
            $this->isAllowedInRest ?? false,
            $this->restBase ?? false,
            $this->restNamespace ?? false,
            $this->restControllerClass ?? false,
            $this->excludeFromSearch,
            $this->showInAdminBar,
            $this->menuPosition,
            $this->menuIcon,
            $this->capabilityType ?? 'post',
            $this->mapMetaCap ?? false,
            $this->supports ?? [],
            $this->registerMetaBoxCb,
            $this->taxonomies ?? [],
            $this->archive ?? false,
            $this->canExport ?? true,
            $this->deleteWithUser,
            $this->template ?? [],
            $this->templateLock ?? false,
            $this->options ?? []
        );
    }

    public static function for(string $name): self
    {
        return new self($name);
    }
}
