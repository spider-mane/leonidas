<?php

namespace WebTheory\Leonidas\Forms\Validators;

use WebTheory\Saveyour\Contracts\FormValidatorInterface;

class WpNonceValidator implements FormValidatorInterface
{
    /**
     *
     */
    protected $name;

    /**
     *
     */
    protected $action;

    /**
     *
     */
    public function __construct($name, $action)
    {
        $this->name = $name;
        $this->action = $action;
    }

    /**
     *
     */
    public function isValid(): bool
    {
        return (bool) wp_verify_nonce($_POST[$this->name], $this->action);
    }
}
