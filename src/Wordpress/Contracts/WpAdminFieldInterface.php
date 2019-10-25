<?php

namespace WebTheory\WordPress\Contracts;

use WebTheory\WordPress\Fields\WpAdminField;

interface WpAdminFieldInterface
{
    /**
     *
     */
    public function setDescription(string $description);

    /**
     *
     */
    public function getDescription(): string;

    /**
     *
     */
    public function setLabel(string $label);

    /**
     *
     */
    public function getLabel(): string;

    /**
     *
     */
    public function getFormFieldController(): WpAdminField;
}
