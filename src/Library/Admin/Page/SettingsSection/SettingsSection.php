<?php

namespace Leonidas\Library\Admin\Page\SettingsSection;

use Leonidas\Contracts\Admin\Components\SettingsSectionInterface;
use Leonidas\Library\Admin\Page\SettingsSection\Traits\HasSettingsSectionDataTrait;
use Leonidas\Traits\CanBeRestrictedTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Html;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class SettingsSection implements SettingsSectionInterface
{
    use CanBeRestrictedTrait;
    use HasSettingsSectionDataTrait;

    public function __construct(
        string $id,
        string $title,
        string $page,
        ?string $description = null,
        ?ServerRequestPolicyInterface $policy = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->page = $page;
        $this->description = $description;
        $this->policy = $policy;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->description ? Html::tag('p', [], $this->description) : '';
    }
}
