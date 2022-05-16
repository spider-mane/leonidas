<?php

namespace Leonidas\Library\Admin\Component\SettingsSection;

use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionInterface;

class SettingsSectionCollection implements SettingsSectionCollectionInterface
{
    /**
     * @var SettingsSectionInterface[]
     */
    protected array $sections = [];

    public function __construct(SettingsSectionCollectionInterface ...$sections)
    {
        array_map([$this, 'add'], $sections);
    }

    public function add(SettingsSectionInterface $section)
    {
        $this->sections[$section->getId()] = $section;
    }

    public function get(string $section): SettingsSectionInterface
    {
        return $this->sections[$section];
    }

    public function remove(string $section)
    {
        unset($this->sections[$section]);
    }

    public function has(string $section): bool
    {
        return isset($this->sections[$section]);
    }

    public function all(): array
    {
        return $this->sections;
    }
}
