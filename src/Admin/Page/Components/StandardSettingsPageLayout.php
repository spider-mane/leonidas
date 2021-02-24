<?php

namespace WebTheory\Leonidas\Admin\Page\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Page\Views\StandardSettingsPageView;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Admin\Traits\RendersWithViewTrait;

class StandardSettingsPageLayout extends AbstractPageLayout implements AdminPageLayoutInterface
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

    /**
     *
     */
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

    /**
     *
     */
    protected function getView(): ViewInterface
    {
        return new StandardSettingsPageView();
    }

    /**
     *
     */
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
