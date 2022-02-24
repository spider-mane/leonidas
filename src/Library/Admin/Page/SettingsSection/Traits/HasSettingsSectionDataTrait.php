<?php

namespace Leonidas\Library\Admin\Page\SettingsSection\Traits;

trait HasSettingsSectionDataTrait
{
    public string $id;

    public string $title;

    public string $page;

    public ?string $description = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
