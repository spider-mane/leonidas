<?php

namespace Leonidas\Library\System\Schema\Option;

use Leonidas\Contracts\System\Schema\Option\OptionManagerInterface;

class OptionManager implements OptionManagerInterface
{
    public function add(string $option, mixed $value): bool
    {
        return add_option($option, $value);
    }

    public function get(string $option, mixed $default = null): mixed
    {
        return get_option($option, $default);
    }

    public function update(string $option, mixed $value): bool
    {
        return update_option($option, $value);
    }

    public function delete(string $option): bool
    {
        return delete_option($option);
    }
}
