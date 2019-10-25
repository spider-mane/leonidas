<?php

namespace WebTheory\Saveyour\Fields;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

abstract class AbstractInput extends AbstractStandardFormControl implements FormFieldInterface
{
    /**
     * @var string
     */
    protected $type = 'text';

    /**
     * @var string
     */
    protected $dataList;

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
            ->addAttribute('value', $this->value)
            ->addAttribute('datalist', $this->dataList);
    }

    /**
     *
     */
    public function toHtml(): string
    {
        return $this
            ->resolveAttributes()
            ->open('input', $this->attributes);
    }
}
