<?php

namespace Leonidas\Framework\Site\Form;

use Leonidas\Framework\Abstracts\UtilizesExtensionTrait;
use ReCaptcha\ReCaptcha;
use WebTheory\Saveyour\Auth\Policy\ReCaptchaPolicy;
use WebTheory\Saveyour\Field\Type\Hidden;

trait AuthenticatesWithReCaptchaTrait
{
    use UtilizesExtensionTrait;

    protected function reCaptchaFormCheck(): string
    {
        return (new Hidden())
            ->setId($response = $this->reCaptchaResponse())
            ->setName($response)
            ->toHtml();
    }

    protected function reCaptchaResponse(): string
    {
        return 'g-recaptcha-response';
    }

    protected function reCaptchaPolicy(string $response): ReCaptchaPolicy
    {
        return new ReCaptchaPolicy($response, $this->reCaptcha());
    }

    protected function reCaptcha(): ReCaptcha
    {
        return new ReCaptcha($this->getConfig('services.recaptcha.secret'));
    }
}
