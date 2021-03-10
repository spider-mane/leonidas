<?php

namespace WebTheory\Leonidas\Contracts\Form;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Contracts\Extension\WpExtensionInterface;
use WebTheory\Saveyour\Contracts\FormProcessingCacheInterface;

interface FormInterface
{
    /**
     *
     */
    public function __construct(WpExtensionInterface $extension);

    /**
     * @return FormProcessingCacheInterface
     */
    public function process(ServerRequestInterface $request): FormProcessingCacheInterface;

    /**
     * @return array
     */
    public function formFields(ServerRequestInterface $request): array;

    /**
     * @return string[]
     */
    public function verificationFields(ServerRequestInterface $request): array;
}
