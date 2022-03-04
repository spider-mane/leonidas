<?php

namespace Leonidas\Library\Admin\Page\SettingsSection;

use Leonidas\Contracts\Admin\Components\SettingsSectionInterface;
use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Library\Admin\Page\SettingsSection\Traits\HasSettingsSectionDataTrait;
use Leonidas\Traits\CanBeRestrictedTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Html;

class SettingsSection implements SettingsSectionInterface
{
    use CanBeRestrictedTrait;
    use HasSettingsSectionDataTrait;

    public function __construct(
        string $id,
        string $title,
        string $page,
        ?string $description = null,
        ?ConstrainerCollectionInterface $constraints = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->page = $page;
        $this->description = $description;
        $this->constraints = $constraints;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->description ? Html::tag('p', [], $this->description) : '';
    }
}
