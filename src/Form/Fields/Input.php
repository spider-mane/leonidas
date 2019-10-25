<?php

namespace WebTheory\Saveyour\Fields;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

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
