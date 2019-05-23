<?php

namespace Backalley\FormFields;

interface FormFieldInterface
{
    /**
     * 
     */
    public function create($args);

    /**
     * 
     */
    public function parse_args($args);

    /**
     * 
     */
    public function toString();
}