<?php

namespace WebTheory\Leonidas;

class Field extends ObjectProxy
{
    /**
     *
     */
    protected static function objectProxySetObject()
    {
        static::$object = Leonidas::get('container')->get('field');
    }
}
