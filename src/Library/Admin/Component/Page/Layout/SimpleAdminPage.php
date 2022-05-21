<?php

namespace Leonidas\Library\Admin\Component\Page\Layout;

use Leonidas\Contracts\Admin\Component\Page\AdminPageComponentInterface;
use Leonidas\Contracts\Admin\Component\Page\AdminPageLayoutInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\MaybeHandlesCsrfTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Leonidas\Library\Admin\Component\Page\View\SimpleAdminPageView;
use Psr\Http\Message\ServerRequestInterface;

class SimpleAdminPage extends AbstractPageLayout implements AdminPageLayoutInterface
{
    use CanBeRestrictedTrait;
    use MaybeHandlesCsrfTrait;
    use RendersWithViewTrait;

    /**
     * Collection of components that fill the layout
     *
     * @var AdminPageComponentInterface[]
     */
    protected array $components = [];

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

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new SimpleAdminPageView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
