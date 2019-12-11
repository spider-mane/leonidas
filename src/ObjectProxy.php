<?php

namespace WebTheory\Leonidas;

use Exception;

abstract class ObjectProxy
{
    /**
     * @var bool
     */
    protected static $initiated = false;

    /**
     * @var object
     */
    protected static $object;

    /**
     *
     */
    public static function objectProxyInit()
    {
        if (false === static::$initiated) {
            static::objectProxySetObject();
            static::$initiated = true;
        } else {
            throw new Exception('Stop It!');
        }
    }

    /**
     *
     */
    public static function __callStatic($name, $args)
    {
        return static::$object->$name(...$args);
    }

    /**
     *
     */
    abstract protected static function objectProxySetObject();
}
