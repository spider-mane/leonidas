<?php

namespace WebTheory\Leonidas\Library\Core\Util;

class Prefixer
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     *
     */
    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     *
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     *
     */
    public function prefixify(string $value, string $divider = '')
    {
        return $this->prefix . $divider . $value;
    }

    /**
     *
     */
    public function dash(string $value)
    {
        return $this->prefixify($value, '-');
    }

    /**
     *
     */
    public function doubleDash(string $value)
    {
        return $this->prefixify($value, '--');
    }

    /**
     *
     */
    public function underscore(string $value)
    {
        return $this->prefixify($value, '_');
    }

    /**
     *
     */
    public function doubleUnderscore(string $value)
    {
        return $this->prefixify($value, '__');
    }

    /**
     *
     */
    public function __invoke(string $value, string $divider = '')
    {
        return $this->prefixify($value, $divider);
    }
}
