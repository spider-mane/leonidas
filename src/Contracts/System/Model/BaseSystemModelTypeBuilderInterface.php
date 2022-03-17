<?php

namespace Leonidas\Contracts\System\Model;

interface BaseSystemModelTypeBuilderInterface
{
    public function name(string $name): self;

    public function plural(string $pluralLabel): self;

    public function singular(?string $singularLabel): self;

    public function description(?string $description): self;

    public function labels(?array $labels): self;

    public function public(?bool $isPublic): self;

    public function hierarchical(?bool $hierarchical): self;

    public function publiclyQueryable(?bool $publiclyQueryable): self;

    public function showInUi(?bool $showInUi): self;

    /**
     * @param null|bool|string $showInMenu
     */
    public function showInMenu($showInMenu): self;

    public function showInNavMenus(?bool $showInNavMenu): self;

    public function capabilities(?array $capabilities): self;

    /**
     * @param null|bool|array $rewrite
     */
    public function rewrite($rewrite): self;

    /**
     * @param null|bool|string $queryVar
     */
    public function queryVar($queryVar): self;

    public function showInRest(?bool $showInRest): self;

    /**
     * @param null|bool|string $restBase
     */
    public function restBase(?string $restBase): self;

    /**
     * @param null|bool|string $restNamespace
     */
    public function restNamespace(?string $restNamespace): self;

    /**
     * @param null|bool|string $restControllerClass
     */
    public function restControllerClass(?string $restControllerClass): self;

    public function options(?array $options): self;
}
