<?php

namespace Leonidas\Contracts\System\Configuration;

interface ModelConfigurationBuilderInterface
{
    /**
     * @return $this
     */
    public function name(string $name): static;

    /**
     * @return $this
     */
    public function plural(string $pluralLabel): static;

    /**
     * @return $this
     */
    public function singular(?string $singularLabel): static;

    /**
     * @return $this
     */
    public function description(?string $description): static;

    /**
     * @return $this
     */
    public function labels(?array $labels): static;

    /**
     * @return $this
     */
    public function public(?bool $isPublic): static;

    /**
     * @return $this
     */
    public function hierarchical(?bool $hierarchical): static;

    /**
     * @return $this
     */
    public function publiclyQueryable(?bool $publiclyQueryable): static;

    /**
     * @return $this
     */
    public function showInUi(?bool $showInUi): static;

    /**
     * @return $this
     */
    public function showInNavMenus(?bool $showInNavMenu): static;

    /**
     * @return $this
     */
    public function capabilities(?array $capabilities): static;

    /**
     * @return $this
     */
    public function rewrite(null|bool|array $rewrite): static;

    /**
     * @return $this
     */
    public function queryVar(null|bool|string $queryVar): static;

    /**
     * @return $this
     */
    public function showInRest(?bool $showInRest): static;

    /**
     * @return $this
     */
    public function restBase(null|bool|string $restBase): static;

    /**
     * @return $this
     */
    public function restNamespace(null|bool|string $restNamespace): static;

    /**
     * @return $this
     */
    public function restControllerClass(null|bool|string $restControllerClass): static;

    /**
     * @return $this
     */
    public function extra(?array $options): static;
}
