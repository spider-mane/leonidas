<?php

namespace Leonidas\Contracts\Option;

interface OptionRepositoryInterface
{
    public function add(string $option, mixed $value): void;

    public function get(string $option, mixed $default = null): mixed;

    public function update(string $option, mixed $value): void;

    public function delete(string $option): void;
}
