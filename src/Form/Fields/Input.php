<?php

namespace Backalley\Form\Fields;

use Backalley\Form\Contracts\FormFieldInterface;

class Input extends AbstractFormField implements FormFieldInterface
{
    /**
     * @var string
     */
    public $type = 'text';

    /**
     * @var string
     */
    public $name;

    /**
     * @var mixed
     */
    public $value;

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param string  $type
     *
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     *
     */
    protected function resolveAttributes()
    {
        return parent::resolveAttributes()
            ->addAttribute('type', $this->type)
            ->addAttribute('value', $this->value);
    }

    /**
     *
     */
    public function toHtml(): string
    {
        $this->resolveAttributes();

        return $this->open('input', $this->attributes);
    }
}
