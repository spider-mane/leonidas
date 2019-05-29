<?php

namespace Backalley\FormFields;

interface FormFieldInterface
{
    /**
     * 
     */
    public static function create($args) : FormFieldInterface;

    /**
     * 
     */
    public function __toString();
}