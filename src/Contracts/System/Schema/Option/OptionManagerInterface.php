<?php

namespace Leonidas\Contracts\System\Schema\Option;

interface OptionManagerInterface
{
    public function add(string $option, mixed $value): bool;

    public function get(string $option, mixed $default = null): mixed;

    public function update(string $option, mixed $value): bool;

    public function delete(string $option): bool;
}
