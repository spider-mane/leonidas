<?php

namespace Leonidas\Library\Admin\Component\Table\Element;

use Leonidas\Contracts\Admin\Component\Table\ColumnRowActionInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Traits\ElementConstructorTrait;

class ColumnRowAction implements ColumnRowActionInterface
{
    use ElementConstructorTrait;
    use CanBeRestrictedTrait;

    protected string $link;

    protected string $title;

    protected string $ariaLabel = '%s';

    protected array $attributes = [];

    public function __construct(string $title, string $link)
    {
        $this->title = $title;
        $this->link = $link;
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
     * @return $this
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
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        $object = $request->getAttribute('object', '');

        $attributes = [
            'href' => sprintf($this->link, $object->slug),
            'aria-label' => sprintf($this->ariaLabel, "&#8220;{$object->name}&#8221;"),
        ];

        return $this->tag('a', $attributes + $this->attributes, $this->title);
    }
}
