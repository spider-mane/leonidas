<?php

/**
 * @package Backalley-Core
 *
 * Factory class to create field
 */

namespace Backalley\FormFields;

use Backalley\Html\TagSage;
use Backalley\FormFields\Fields\Input;
use Backalley\FormFields\Fields\Textarea;
use Backalley\Form\Fields\Select;
use Backalley\FormFields\Fields\Checklist;

class FieldFactory
{
    /**
     *
     */
    protected function __construct()
    {
        // do nothing
    }

    /**
     *
     */
    public function __callStatic($name, $arguments)
    {
        return (new static)->{$name}($arguments);
    }

    /**
     *
     */
    protected function input(array $args)
    {
        return new Input;
    }

    /**
     *
     */
    protected function select(array $args)
    {
        return new Select;
    }

    /**
     *
     */
    protected function textarea(array $args)
    {
        return new Textarea;
    }

    /**
     *
     */
    protected function checklist(array $args)
    {
        return new Checklist;
    }
}
