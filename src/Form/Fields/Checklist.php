<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Form\Fields;

use Backalley\Form\Fields\Input;
use Backalley\Form\Elements\Label;
use Backalley\Form\Contracts\FormFieldInterface;

class Checklist extends AbstractFormField implements FormFieldInterface
{
    /**
     * Associative array of item definitions with the value as the key
     *
     * @var array
     */
    public $items = [];

    /**
     *
     */
    public $value = [];

    /**
     * Value for hidden input that facilitates unsetting all values on the server
     *
     * @var string
     */
    public $clearControl;

    /**
     * Value for hidden input that facilitates unsetting single value on the server
     *
     * @var mixed
     */
    public $toggleControl;

    /**
     * {@inheritDoc}
     */
    protected const INPUT = 'checkbox';

    /**
     * {@inheritDoc}
     */
    protected const SELECTED = 'checked';

    // use SupportsMultipleValuesTrait;

    /**
     *
     */
    public function setValue($value)
    {
        $this->value[] = $value;
    }

    /**
     * Get the value of items
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the value of items
     *
     * @param mixed $items
     *
     * @return self
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get value for hidden input that facilitates unsetting all values on the server
     *
     * @return string
     */
    public function getClearControl(): string
    {
        return $this->clearControl;
    }

    /**
     * Set value for hidden input that facilitates unsetting all values on the server
     *
     * @param string
     *
     * @return self
     */
    public function setClearControl(string $clearControl)
    {
        $this->clearControl = $clearControl;

        return $this;
    }

    /**
     * Get value for hidden input that facilitates unsetting single value on the server
     *
     * @return mixed
     */
    public function getToggleControl(): mixed
    {
        return $this->toggleControl;
    }

    /**
     * Set value for hidden input that facilitates unsetting single value on the server
     *
     * @param mixed $toggleControl
     *
     * @return self
     */
    public function setToggleControl($toggleControl)
    {
        $this->toggleControl = $toggleControl;

        return $this;
    }

    /**
     *
     */
    protected function resolveAttributes()
    {
        $this->addClass('thing');

        return parent::resolveAttributes();
    }

    /**
     *
     */
    public function toHtml(): string
    {
        $this->resolveAttributes();

        $html = '';

        $html .= $this->open('div', $this->attributes ?? null);
        $html .= isset($this->clearControl)
            ? (new Input)->setType('hidden')->setName($this->name)->setValue($this->clearControl)
            : '';

        $html .= $this->open('ul');

        foreach ($this->items as $item => $element) {

            $itemId = $element['id'] ?? null;
            $itemName = $this->name . "[{$element['name']}]" ?? '';
            $itemLabel = $element['label'] ?? null;

            $html .= $this->open('li');
            $html .= isset($this->toggleControl)
                ? (new Input)->setType('hidden')->setName($itemName)->setValue($this->toggleControl)
                : '';

            $html .= (new Input)
                ->setId($itemId)
                ->setValue($item)
                ->setType($this::INPUT)
                ->setName($itemName)
                ->addAttribute($this::SELECTED, in_array($item, $this->value) ? true : false);

            $html .= (new Label($itemLabel))->setFor($itemId);

            // close li
            $html .= $this->close('li');
        }

        $html .= $this->close('ul');
        $html .= $this->close('div');

        return $html;
    }
}
