<?php

namespace WebTheory\Form\Fields;

use WebTheory\Form\Contracts\FormFieldInterface;

class Input extends AbstractInput implements FormFieldInterface
{
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
}
