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

    public static function key(string $key): ConfigReflector
    {
        return new static(function () use ($key) {
            /** @var ConfigInterface $this */
            return $this->get($key);
        });
    }

    public static function map(array $map): ConfigReflector
    {
        return new static(function () use ($map) {
            /** @var ConfigInterface $this */
            return array_map([$this, 'get'], $map);
        });
    }

    public static function mix(array $map, string $symbol = '@'): ConfigReflector
    {
        return new static(function () use ($map, $symbol) {
            /** @var ConfigInterface $this */
            foreach ($map as $key => $value) {
                if (strpos($symbol, $value) !== 0) {
                    continue;
                }

                $map[$key] = $this->get(ltrim($value, $symbol));
            }

            return $map;
        });
    }

    public static function defaultMap(array $map): ConfigReflector
    {
        return new static(function () use ($map) {
            /** @var ConfigInterface $this */
            foreach ($map as $key => $values) {
                $map[$key] = $this->get($values[0], $values[1]);
            }

            return $map;
        });
    }

    public static function defaultMix(array $map, string $symbol = '#'): ConfigReflector
    {
        return new static(function () use ($map, $symbol) {
            /** @var ConfigInterface $this */
            foreach ($map as $key => $values) {
                if (strpos($symbol, $key) !== 0) {
                    continue;
                }

                unset($map[$key]);
                $map[ltrim($key, $symbol)] = $this->get($values[0], $values[1]);
            }

            return $map;
        });
    }
}
