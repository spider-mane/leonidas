<?php

namespace Leonidas\Contracts\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\AdminComponentInterface;
use Leonidas\Contracts\Admin\Component\InputProcessorInterface;
use WP_Screen;

interface MetaboxInterface extends AdminComponentInterface, InputProcessorInterface
{
    public function getId(): string;

    public function getTitle(): string;

    /**
     * @return string|array<string>|WP_Screen
     */
    public function getScreen(): string|array|WP_Screen;

    public function getContext(): string;

    public function getPriority(): string;

    public function getArgs(): array;
}
