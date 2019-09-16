<?php

namespace Backalley\Wordpress\Contracts;

use Backalley\Wordpress\Fields\WpAdminField;

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
