<?php

namespace Leonidas\Library\Core\View\Twig;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

class ComponentAttributeBag implements ArrayAccess, IteratorAggregate
{
    /**
     * The raw array of attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Create a new component attribute bag instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $this->resolveAttributes($attributes);
    }

    protected function resolveAttributes(array $attributes)
    {
        return $this->hasNestedAttributes($attributes)
            ? $this->extractNestedAttributes($attributes)
            : $attributes;
    }

    protected function hasNestedAttributes(array $attributes): bool
    {
        return array_key_exists('attributes', $attributes)
            && $attributes['attributes'] instanceof ComponentAttributeBag;
    }

    protected function extractNestedAttributes($attributes): array
    {
        $parentAttributes = $attributes['attributes'];

        unset($attributes['attributes']);

        return $attributes + $parentAttributes->getAttributes();
    }

    /**
     * Get the first attribute's value.
     *
     * @param mixed $default
     * @return mixed
     */
    public function first($default = null)
    {
        return $this->getIterator()->current() ?? $default;
    }

    /**
     * Get a given attribute from the attribute array.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = '')
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Get a given attribute from the attribute array.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Only include the given attribute from the attribute array.
     *
     * @param mixed|array $keys
     * @return static
     */
    public function only($keys)
    {
        if (is_null($keys)) {
            $values = $this->attributes;
        } else {
            $keys = is_array($keys) ? $keys : [$keys];

            $values = array_filter(
                $this->attributes,
                function ($key) use ($keys) {
                    return in_array($key, $keys);
                },
                ARRAY_FILTER_USE_KEY
            );
        }

        return new static($values);
    }

    /**
     * Exclude the attributes given from the attribute array.
     *
     * @param mixed|array $keys
     *
     * @return static
     */
    public function except($keys)
    {
        if (is_null($keys)) {
            $values = $this->attributes;
        } else {
            $keys = is_array($keys) ? $keys : [$keys];

            $values = array_filter(
                $this->attributes,
                function ($key) use ($keys) {
                    return !in_array($key, $keys);
                },
                ARRAY_FILTER_USE_KEY
            );
        }

        return new static($values);
    }

    /**
     * Merge additional attributes / values into the attribute bag.
     *
     * @param array $extra
     * @return static
     */
    public function merge(array $extra = [])
    {
        $attributes = $this->getAttributes();

        foreach ($extra as $key => $value) {
            if (!array_key_exists($key, $attributes)) {
                $attributes[$key] = '';
            }
        }

        foreach ($attributes as $key => $value) {
            // $attributes[$key] = trim($value . ' ' . ($extra[$key] ?? ''));
            $attributes[$key] = trim(($extra[$key] ?? '') . ' ' . $value);
        }

        return new static($attributes);
    }

    public function class($defaultClass = '')
    {
        return $this->merge(['class' => $defaultClass]);
    }

    /**
     * Get all of the raw attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the underlying attributes.
     *
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes)
    {
        if (
            isset($attributes['attributes']) &&
            $attributes['attributes'] instanceof self
        ) {
            /** @var static $parentBag */
            $parentBag = $attributes['attributes'];

            unset($attributes['attributes']);

            $attributes = $parentBag->merge($attributes)->getAttributes();
        }

        $this->attributes = $attributes;
    }

    /**
     * Determine if the given offset exists.
     *
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * Get the value at the given offset.
     *
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * Set the value at a given offset.
     *
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Remove the value at the given offset.
     *
     * @param string $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }

    /**
     * Implode the attributes into a single HTML ready string.
     *
     * @return string
     */
    public function __toString()
    {
        $string = '';

        foreach ($this->attributes as $key => $value) {
            if ($value === false || is_null($value)) {
                continue;
            }

            if ($value === true) {
                $value = $key;
            }

            $string .= ' ' . $key . '="' . str_replace('"', '\\"', trim($value)) . '"';
        }

        return trim($string);
    }
}
