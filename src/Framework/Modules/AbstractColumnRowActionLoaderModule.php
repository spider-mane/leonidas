<?php

namespace Leonidas\Framework\Modules;

use Closure;
use Leonidas\Contracts\Admin\Components\ColumnRowActionInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use WebTheory\Html\Traits\ElementConstructorTrait;

abstract class AbstractColumnRowActionLoaderModule extends AbstractModule implements ModuleInterface
{
    use ElementConstructorTrait;
    use CanBeRestrictedTrait;

    protected string $entity;

    protected ?string $action = null;

    protected ColumnRowActionInterface $columnRow;

    public function getAction(): string
    {
        return $this->action;
    }

    public function hook(): void
    {
        add_filter(
            "{$this->screen()}_row_actions",
            Closure::fromCallable([$this, 'filterXRowActions']),
            $this->xRowActionsPriority(),
            PHP_INT_MAX
        );
    }

    public function filterXRowActions($actions, $object)
    {
        $request = $this->getServerRequest()
            ->withAttribute('object', $object);

        foreach ($this->actions() as $action) {
            $actions[$action->getTitle()] = $action->renderComponent($request);
        }

        return $actions;
    }

    protected function xRowActionsPriority(): int
    {
        return 10;
    }

    abstract protected function screen(): string;

    /**
     * @return ColumnRowActionInterface[]
     */
    abstract protected function actions();
}
