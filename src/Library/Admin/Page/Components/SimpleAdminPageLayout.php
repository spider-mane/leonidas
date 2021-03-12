<?php

namespace Leonidas\Library\Admin\Page\Components;

use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Contracts\Admin\Components\AdminPageComponentInterface;
use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Page\Views\SimpleAdminPageView;
use Leonidas\Traits\CanBeRestrictedTrait;
use Leonidas\Traits\RendersWithViewTrait;
use Leonidas\Traits\MaybeHandlesCsrfTrait;

class SimpleAdminPageLayout extends AbstractPageLayout implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
    use MaybeHandlesCsrfTrait;
    use RendersWithViewTrait;

    /**
     * Collection of components that fill the layout
     *
     * @var AdminPageComponentInterface[]
     */
    protected $components = [];

    /**
     * @var string
     */
    protected $template = 'page/admin-page.twig';

    /**
     *
     */
    public function __construct(AdminPageComponentInterface ...$components)
    {
        $this->components = $components;
    }

    /**
     * Get components
     *
     * @return AdminPageComponentInterface[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * Add components
     *
     * @param AdminPageComponentInterface[] $components
     */
    public function addComponents(array $components)
    {
        foreach ($components as $component) {
            $this->addComponent($component);
        }

        return $this;
    }

    /**
     * Add single component
     *
     * @param AdminPageComponentInterface $component
     */
    public function addComponent(AdminPageComponentInterface $component)
    {
        $this->components[] = $component;

        return $this;
    }

    /**
     *
     */
    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new SimpleAdminPageView();
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
        ];
    }
}
