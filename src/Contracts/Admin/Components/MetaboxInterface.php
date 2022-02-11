<?php

namespace Leonidas\Contracts\Admin\Components;

interface MetaboxInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getTitle(): string;

    /**
     * @return string|string[]|WP_Screen
     */
    public function getScreen();

    public function getContext(): ?string;

    public function getPriority(): ?string;

    public function getArgs(): ?array;
}
