<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface WpExtensionInterface
{
    /**
     *
     */
    public function getConfig(string $name, $default);

    /**
     *
     */
    public function getPrefix(): string;

    /**
     *
     */
    public function getName(): string;

    /**
     *
     */
    public function getType(): string;
}
