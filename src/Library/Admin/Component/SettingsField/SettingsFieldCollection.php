<?php

namespace Leonidas\Library\Admin\Component\SettingsField;

use Leonidas\Contracts\Admin\Component\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsFieldInterface;

class SettingsFieldCollection implements SettingsFieldCollectionInterface
{
    /**
     * @var SettingsFieldInterface[]
     */
    protected array $fields = [];

    public function __construct(SettingsFieldInterface ...$fields)
    {
        array_map([$this, 'add'], $fields);
    }

    public function add(SettingsFieldInterface $field)
    {
        $this->fields[$field->getId()] = $field;
    }

    public function get(string $field): SettingsFieldInterface
    {
        return $this->fields[$field];
    }

    public function remove(string $field)
    {
        unset($this->fields[$field]);
    }

    public function has(string $field): bool
    {
        return isset($this->fields[$field]);
    }

    public function all(): array
    {
        return $this->fields;
    }
}
