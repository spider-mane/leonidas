<?php

namespace WebTheory\Leonidas\Forms;

use Theme\AbstractForm;

class FormRepository
{
    /**
     *
     */
    protected static $forms;

    /**
     *
     */
    public static function add(string $id, AbstractForm $form)
    {
        static::$forms[$id] = $form;
    }

    /**
     *
     */
    public static function get(string $form)
    {
        return static::$forms[$form];
    }
}
