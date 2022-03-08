<?php

namespace Leonidas\Library\Admin\Page\Layouts;

use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Page\Views\StandardSettingsPageView;
use Leonidas\Traits\CanBeRestrictedTrait;
use Leonidas\Traits\RendersWithViewTrait;
use Psr\Http\Message\ServerRequestInterface;

class StandardSettingsPage extends AbstractPageLayout implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    /**
     * @var string
     */
    protected $page;

    /**
     * @var string
     */
    protected $optionGroup;

    public function __construct(string $page, string $optionGroup)
    {
        $this->page = $page;
        $this->optionGroup = $optionGroup;
    }

    /**
     * Get the value of page
     *
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * Get optionGroup
     *
     * @return string
     */
    public function getOptionGroup(): string
    {
        return $this->optionGroup;
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new StandardSettingsPageView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'title' => $this->title,
            'page' => $this->page,
            'description' => $this->description,
            'option_group' => $this->optionGroup,
        ];
    }
}
