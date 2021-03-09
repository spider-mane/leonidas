<?php

namespace WebTheory\Leonidas\Admin\Page\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminPageComponentInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Admin\Page\Views\SimpleAdminPageView;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Admin\Traits\RendersWithViewTrait;
use WebTheory\Leonidas\Traits\MaybeHandlesCsrfTrait;

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
