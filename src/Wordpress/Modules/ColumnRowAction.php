<?php

namespace Backalley\WordPress\Modules;

use Backalley\Html\Traits\ElementConstructorTrait;

class ColumnRowAction
{
    use ElementConstructorTrait;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $ariaLabel = '%s';

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     *
     */
    public function __construct(string $entity, string $action, string $title, string $link)
    {
        $this->entity = $entity;
        $this->action = $action;
        $this->title = $title;
        $this->link = $link;
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
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the value of link
     *
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * Get the value of ariaLabel
     *
     * @return string
     */
    public function getAriaLabel(): string
    {
        return $this->ariaLabel;
    }

    /**
     * Set the value of ariaLabel
     *
     * @param string $ariaLabel
     *
     * @return self
     */
    public function setAriaLabel(string $ariaLabel)
    {
        $this->ariaLabel = $ariaLabel;

        return $this;
    }

    /**
     * Get the value of attributes
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Set the value of attributes
     *
     * @param array $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     *
     */
    public function hook()
    {
        add_filter("{$this->entity}_row_actions", [$this, 'filter'], null, 2);
    }

    /**
     *
     */
    public function filter($actions, $object)
    {
        $attributes = [
            'href' => sprintf($this->link, $object->slug),
            'aria-label' => sprintf($this->ariaLabel, "&#8220;{$object->name}&#8221;")
        ];

        $actions[$this->action] = $this->tag('a', $this->title, $attributes + $this->attributes);

        return $actions;
    }
}
