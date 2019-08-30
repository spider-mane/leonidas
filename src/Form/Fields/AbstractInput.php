<?php

namespace Backalley\Form\Fields;

use Backalley\Form\Contracts\FormFieldInterface;

abstract class AbstractInput extends AbstractFormField implements FormFieldInterface
{
    /**
     * @var string
     */
    protected $type = 'text';

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
