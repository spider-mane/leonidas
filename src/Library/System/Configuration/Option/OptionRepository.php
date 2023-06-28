<?php

namespace Leonidas\Library\System\Configuration\Option;

use Leonidas\Contracts\Option\OptionRepositoryInterface;
use Leonidas\Contracts\System\Schema\Option\OptionManagerInterface;

class OptionRepository implements OptionRepositoryInterface
{
    protected OptionManagerInterface $manager;

    public function __construct(OptionManagerInterface $optionManager)
    {
        $this->manager = $optionManager;
    }

    public function get(string $option, mixed $default = null): mixed
    {
        return $this->manager->get($option, $default);
    }

    public function add(string $option, mixed $value): void
    {
        $this->manager->add($option, $value);
    }

    public function update(string $option, mixed $value): void
    {
        $this->manager->update($option, $value);
    }

    public function delete(string $option): void
    {
        $this->manager->delete($option);
    }
}
