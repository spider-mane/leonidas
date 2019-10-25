<?php

namespace WebTheory\Form\Fields;

use WebTheory\Form\Contracts\FormFieldInterface;

class Textarea extends AbstractStandardFormControl implements FormFieldInterface
{
    /**
     * @var int
     */
    public $rows;

    /**
     * Get the value of rows
     *
     * @return int
     */
    public function getRows(): int
    {
        return $this->rows;
    }

    /**
     * Set the value of rows
     *
     * @param int $rows
     *
     * @return self
     */
    public function setRows(int $rows)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     *
     */
    protected function resolveAttributes()
    {
        return parent::resolveAttributes()
            ->addAttribute('rows', $this->rows);
    }

    /**
     *
     */
    public function toHtml(): string
    {
        return $this
            ->resolveAttributes()
            ->tag('textarea', $this->value, $this->attributes);
    }
}
