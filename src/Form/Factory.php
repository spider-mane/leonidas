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

class Factory
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
    protected function input()
    {
        return new Input;
    }

    /**
     *
     */
    protected function select()
    {
        return new Select;
    }

    /**
     *
     */
    protected function textarea()
    {
        return new Textarea;
    }

    /**
     *
     */
    protected function checklist()
    {
        return new Checklist;
    }
}
