<?php

namespace WebTheory\Saveyour\Validation;

use WebTheory\Saveyour\Contracts\FormValidatorInterface;

class ReCaptcha3Validator implements FormValidatorInterface
{
    /**
     *
     */
    protected $reCaptcha;

    /**
     *
     */
    protected $secret;

    /**
     *
     */
    protected $action;

    public const URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     *
     */
    public function __construct(string $reCaptcha, string $secret, ?string $action = null)
    {
        $this->reCaptcha = $reCaptcha;
        $this->secret = $secret;
        $this->action = $action;
    }

    /**
     *
     */
    public function isValid(): bool
    {
        $response = $_POST[$this->reCaptcha];

        $url = static::URL . "?secret={$this->secret}&response={$response}";

        $status = json_decode(file_get_contents($url), true);

        // exit(var_dump($status));

        if ($status['success'] && $status['score'] >= 0.5) {
            return true;
        }

        return false;
    }
}
