<?php

namespace WebTheory\Form\Fields;

use WebTheory\Form\Contracts\FormFieldInterface;

class Checkbox extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'checkbox';

    /**
     * @var bool
     */
    protected $checked;

    /**
     * Get the value of selected
     *
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->checked;
    }

    /**
     * Set the value of selected
     *
     * @param bool $selected
     *
     * @return self
     */
    public function setChecked(bool $selected)
    {
        $this->checked = $selected;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function resolveAttributes()
    {
        return parent::resolveAttributes()
            ->addAttribute('checked', $this->checked);
    }
}
