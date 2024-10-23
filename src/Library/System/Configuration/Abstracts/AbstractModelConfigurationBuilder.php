<?php

namespace Leonidas\Library\System\Configuration\Abstracts;

use Leonidas\Contracts\System\Configuration\ModelConfigurationBuilderInterface;

abstract class AbstractModelConfigurationBuilder implements ModelConfigurationBuilderInterface
{
    protected string $name;

    protected string $pluralLabel;

    protected ?string $singularLabel = null;

    protected ?string $description = null;

    protected ?array $labels = null;

    protected ?bool $isPublic = null;

    protected ?bool $hierarchical = null;

    protected ?bool $publiclyQueryable = null;

    protected ?bool $isAllowedInUi = null;

    protected null|bool|string $displayedInMenu = null;

    protected ?bool $isAllowedInNavMenus = null;

    protected ?array $capabilities = null;

    protected null|bool|array $rewrite = null;

    protected null|bool|string $queryVar = null;

    protected ?bool $isAllowedInRest = null;

    protected null|bool|string $restBase = null;

    protected null|bool|string $restNamespace = null;

    protected null|bool|string $restControllerClass = null;

    protected ?array $extra = null;

    public function __construct(?string $name = null)
    {
        $name && $this->name = $name;
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function plural(string $pluralLabel): static
    {
        $this->pluralLabel = $pluralLabel;

        return $this;
    }

    public function singular(?string $singularLabel): static
    {
        $this->singularLabel = $singularLabel;

        return $this;
    }

    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function labels(?array $labels): static
    {
        $this->labels = $labels;

        return $this;
    }

    public function public(?bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function hierarchical(?bool $hierarchical): static
    {
        $this->hierarchical = $hierarchical;

        return $this;
    }

    public function publiclyQueryable(?bool $publiclyQueryable): static
    {
        $this->publiclyQueryable = $publiclyQueryable;

        return $this;
    }

    public function showInUi(?bool $showInUi): static
    {
        $this->isAllowedInUi = $showInUi;

        return $this;
    }

    public function showInNavMenus(?bool $showInNavMenu): static
    {
        $this->displayedInMenu = $showInNavMenu;

        return $this;
    }

    public function capabilities(?array $capabilities): static
    {
        $this->capabilities = $capabilities;

        return $this;
    }

    public function rewrite($rewrite): static
    {
        $this->rewrite = $rewrite;

        return $this;
    }

    public function queryVar($queryVar): static
    {
        $this->queryVar = $queryVar;

        return $this;
    }

    public function showInRest(?bool $showInRest): static
    {
        $this->isAllowedInRest = $showInRest;

        return $this;
    }

    public function restBase($restBase): static
    {
        $this->restBase = $restBase;

        return $this;
    }

    public function restNamespace($restNamespace): static
    {
        $this->restNamespace = $restNamespace;

        return $this;
    }

    public function restControllerClass($restControllerClass): static
    {
        $this->restControllerClass = $restControllerClass;

        return $this;
    }

    public function extra(?array $extraArgs): static
    {
        $this->extra = $extraArgs;

        return $this;
    }
}
