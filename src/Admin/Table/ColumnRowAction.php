<?php

namespace WebTheory\Leonidas\Admin\Table;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Html\Traits\ElementConstructorTrait;
use WebTheory\Leonidas\Contracts\Admin\Components\ColumnRowActionInterface;
use WebTheory\Leonidas\Traits\CanBeRestrictedTrait;

class ColumnRowAction
{
    use ElementConstructorTrait;
    use CanBeRestrictedTrait;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var ColumnRowActionInterface
     */
    protected $columnRow;

    /**
     *
     */
    public function __construct(string $entity, string $action, ColumnRowActionInterface $columnRow)
    {
        $this->entity = $entity;
        $this->action = $action;
        $this->columnRow = $columnRow;
    }

    /**
     * Get the value of action
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     *
     */
    public function hook()
    {
        add_filter("{$this->entity}_row_actions", [$this, 'renderColumnRowAction'], null, 2);
    }

    /**
     *
     */
    public function renderColumnRowAction($actions, $object)
    {
        $request = ServerRequest::fromGlobals()
            ->withAttribute('object', $object);

        $actions[$this->action] = $this->columnRow->renderComponent($request);

        return $actions;
    }
}
