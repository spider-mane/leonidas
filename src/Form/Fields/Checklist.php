<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Form\Fields;

use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\DataSchemes\IO;
use Backalley\Form\Elements\Label;
use Backalley\Form\Fields\Input;

class Checklist extends AbstractFormField implements FormFieldInterface, IO
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
     *
     */
    public function setValue($value)
    {
        $this->value = $value;
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
    public function toHtml(): string
    {
        $this->resolveAttributes();

        $html = '';

        $html .= $this->open('div', $this->attributes ?? null);
        $html .= isset($this->clearControl)
            ? (new Hidden)->setName($this->name . "[]")->setValue($this->clearControl)
            : '';

        $html .= $this->open('ul');

        foreach ($this->items as $item => $element) {

            $itemId = $element['id'] ?? null;
            $itemName = $element['name'] ?? '';
            $itemFullName = $this->name . "[{$itemName}]";
            $itemValue = $element['value'] ?? '';
            $itemLabel = $element['label'] ?? null;

            $html .= $this->open('li');
            $html .= isset($this->toggleControl)
                ? (new Hidden)->setName($itemFullName)->setValue($this->toggleControl)
                : '';

            $html .= (new Checkbox)
                ->setChecked(in_array($item, $this->value) ? true : false)
                ->setId($itemId)
                ->setValue($itemValue)
                ->setName($itemFullName);

            $html .= (new Label($itemLabel))->setFor($itemId);

            $html .= $this->close('li');
        }

        $html .= $this->close('ul');
        $html .= $this->close('div');

        return $html;
    }
}
