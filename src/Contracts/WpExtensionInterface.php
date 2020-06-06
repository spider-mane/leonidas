<?php

namespace WebTheory\Leonidas\Contracts;

use Psr\Container\ContainerInterface;

interface WpExtensionInterface extends ContainerInterface
{
    /**
     *
     */
    public function config(string $name, $default);

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
