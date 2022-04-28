<?php

namespace Tests\Support\Concerns;

trait HelperTrait
{
    /**
     * "Method Under Test" template for use as keys in data providers.
     */
    protected function mut(string $method, string $extra = ''): string
    {
        $method = "method={$method}()";

        return $extra ? "$method, $extra" : $method;
    }

    /**
     * Call a method on an object with provided arguments. Helpful for tests
     * whose actions are defined by data providers.
     */
    protected function performSystemAction(object $object, string $method, array $args)
    {
        return $object->{$method}(...array_values($args));
    }

    /**
     * Create an indexed array of specified count using a callback to generate
     * each entry.
     */
    protected function dummyList(callable $generator, int $count = 10): array
    {
        return array_map(fn () => $generator(), range(1, $count));
    }

    /**
     * Create an associative array using a callback to generate entries with
     * keys derived from a provided list.
     */
    protected function dummyMap(callable $generator, array $keys): array
    {
        return array_map(fn () => $generator(), array_flip($keys));
    }

    /**
     * Create an associative array of specified count using callbacks to
     * generate both keys and entries.
     */
    protected function dummyKeyMap(callable $keyGen, callable $valueGen, int $count = 10): array
    {
        return $this->dummyMap($valueGen, $this->dummyList($keyGen, $count));
    }
}
