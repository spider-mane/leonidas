<?php

namespace Leonidas\Library\System\Schema\Option;

use Leonidas\Contracts\System\Schema\Option\OptionManagerInterface;

class OptionManager implements OptionManagerInterface
{
    public function add(string $option, mixed $value): void
    {
        add_option($option, $value);
    }

    public function get(string $option, mixed $default = null): mixed
    {
        return get_option($option, $default);
    }

    public function update(string $option, mixed $value): void
    {
        update_option($option, $value);
    }

    public function delete(string $option): void
    {
        delete_option($option);
    }
}
