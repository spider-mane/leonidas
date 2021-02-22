<?php

namespace WebTheory\Leonidas\Admin\Page\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Admin\Traits\UsesTwigView;

class StandardSettingsPageLayout extends AbstractPageLayout implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
    use UsesTwigView;

    /**
     * @var string
     */
    protected $page;

    /**
     * @var string
     */
    protected $optionGroup;

    /**
     * @var string
     */
    protected $template = 'settings-page-template.twig';

    /**
     *
     */
    public function __construct(string $page, string $optionGroup)
    {
        $this->page = $page;
        $this->optionGroup = $optionGroup;
        $this->view = $this->getDefaultView();
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
    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->renderTemplate($this->getTemplateContext());
    }

    /**
     *
     */
    protected function getTemplateToRender(): string
    {
        return $this->template;
    }

    /**
     *
     */
    protected function getTemplateContext(): array
    {
        return [
            'title' => $this->title,
            'page' => $this->page,
            'description' => $this->description,
            'option_group' => $this->optionGroup,
        ];
    }
}
