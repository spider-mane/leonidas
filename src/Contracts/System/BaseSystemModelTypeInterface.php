<?php

namespace Leonidas\Contracts\System;

interface BaseSystemModelTypeInterface
{
    public function getName(): string;

    public function getPluralLabel(): string;

    public function getSingularLabel(): string;

    public function getDescription(): string;

    public function getLabels(): array;

    public function isPublic(): bool;

    public function isHierarchical(): bool;

    public function isPubliclyQueryable(): bool;

    public function isAllowedInUi(): bool;

    /**
     * @return bool|string
     */
    public function getDisplayedInMenu();

    public function isAllowedInNavMenus(): bool;

    public function getCapabilities(): array;

    /**
     * @return bool|array
     */
    public function getRewrite();

    /**
     * @return bool|string
     */
    public function getQueryVar();

    public function isAllowedInRest(): bool;

    /**
     * @return bool|string
     */
    public function getRestBase();

    /**
     * @return bool|string
     */
    public function getRestNamespace();

    /**
     * @return bool|string
     */
    public function getRestControllerClass();

    public function getOptions(): array;
}
