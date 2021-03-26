<?php

namespace Leonidas\Framework;

use Closure;
use Leonidas\Contracts\Container\ConfigReflectorInterface;
use Noodlehaus\ConfigInterface;

class ConfigReflector implements ConfigReflectorInterface
{
    /**
     * @var Closure
     */
    protected $closure;

    public function __construct(Closure $closure)
    {
        $this->$closure = $closure;
    }

    public function reflect(ConfigInterface $config)
    {
        return $this->closure->call($config);
    }

    public function __invoke(ConfigInterface $config)
    {
        return $this->reflect($config);
    }

    public static function from(Closure $closure): ConfigReflector
    {
        return new static($closure);
    }
}
