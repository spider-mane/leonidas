<?php

namespace Leonidas\Contracts\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\AdminComponentInterface;
use Leonidas\Contracts\Admin\Component\WP_Screen;

interface MetaboxInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getTitle(): string;

    /**
     * @return string|string[]|WP_Screen
     */
    public function getScreen();

    public function getContext(): string;

    public function getPriority(): string;

    public function getArgs(): array;
}
