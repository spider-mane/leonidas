<?php

namespace Backalley\FormFields;

use Backalley\FormFields\Contracts\FormFieldInterface;


class Select extends AbstractFormField implements FormFieldInterface
{
    /**
     *
     */
    public $options = [];

    /**
     *
     */
    public $value = [];

    /**
     * @var bool
     */
    public $multiple = false;

    /**
     * @var int
     */
    public $size;

    /**
     *
     */
    public function __construct()
    {
        // do something maybe
    }

    /**
     * Get the value of options
     *
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @param mixed $options
     *
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Set the value of value
     *
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value[] = $value;

        return $this;
    }

    /**
     *
     */
    protected function resolveAttributes()
    {
        return parent::resolveAttributes();
    }

    /**
     *
     */
    public function render()
    {
        $this->resolveAttributes();

        $html = '';

        $html .= $this->open('select', $this->attributes);

        foreach ($this->options as $value => $option) {
            $optionAttr = ['value' => $value];

            if (in_array($value, $this->value)) {
                $optionAttr['selected'] = true;
            }

            $html .= $this->open('option', $optionAttr);
            $html .= $option;
            $html .= $this->close('option');
        }

        $html .= $this->close('select');

        return $html;
    }
}
