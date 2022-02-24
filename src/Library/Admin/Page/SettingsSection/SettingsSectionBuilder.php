<?php

namespace Leonidas\Library\Admin\Page\SettingsSection;

use Leonidas\Contracts\Admin\Components\SettingsSectionBuilderInterface;
use Leonidas\Contracts\Admin\Components\SettingsSectionInterface;
use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Library\Admin\Page\SettingsSection;
use Leonidas\Library\Admin\Page\SettingsSection\Traits\HasSettingsSectionDataTrait;

class SettingsSectionBuilder implements SettingsSectionBuilderInterface
{
    use HasSettingsSectionDataTrait;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(string $id)
    {
        $this->id = $id;
    }

    public function title(string $title)
    {
        $this->title = $title;
    }

    public function page(string $page)
    {
        $this->page = $page;
    }

    public function description(string $description)
    {
        $this->description = $description;
    }

    public function constraints(?ConstrainerCollectionInterface $constraints)
    {
        $this->constraints = $constraints;
    }

    public function getConstraints(): ?ConstrainerCollectionInterface
    {
        return $this->constraints;
    }

    public function get(): SettingsSectionInterface
    {
        return new SettingsSection(
            $this->getId(),
            $this->getTitle(),
            $this->getPage(),
            $this->getDescription(),
            $this->getConstraints(),
        );
    }
}
