<?php

namespace WebTheory\Leonidas\Library\Core\Http\Form;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Library\Admin\Forms\Validators\WpNonceValidator;
use WebTheory\Leonidas\Contracts\Form\FormInterface;
use WebTheory\Leonidas\Library\Core\Auth\Nonce;
use WebTheory\Saveyour\Contracts\FormDataProcessorInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormProcessingCacheInterface;
use WebTheory\Saveyour\Contracts\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;
use WebTheory\Saveyour\Controllers\FormSubmissionManager;

abstract class AbstractFormHandler implements FormInterface
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     *
     */
    public function __construct()
    {
        $this->config = $this->config();
    }

    /**
     *
     */
    public function process(ServerRequestInterface $request): FormProcessingCacheInterface
    {
        return $this->formSubmissionManager()->process($this->request($request));
    }

    /**
     *
     */
    public function formFields(ServerRequestInterface $request): array
    {
        $fieldData = $this->config['fields'];
        $controllers = $this->formFieldControllers();

        foreach ($fieldData as $field => &$data) {
            $controller = $controllers[$field];

            $data['name'] = $controller->getRequestVar();
            $data['value'] = $controller->getPresetValue($request);
        }

        return $fieldData;
    }

    /**
     * @return string[]
     */
    public function verificationFields(ServerRequestInterface $request): array
    {
        return ['nonce' => $this->createNonce()->field()];
    }

    /**
     *
     */
    protected function formSubmissionManager(): FormSubmissionManagerInterface
    {
        return (new FormSubmissionManager())
            ->setValidators($this->formRequestValidators())
            ->setFields(...$this->formFieldControllers())
            ->setProcessors(...$this->formDataProcessors());
    }

    /**
     * @return FormValidatorInterface[]
     */
    protected function formRequestValidators(): array
    {
        return ['nonce' => new WpNonceValidator($this->createNonce())];
    }

    /**
     *
     */
    protected function createNonce(): Nonce
    {
        $nonce = $this->config['nonce'];

        return new Nonce($nonce['name'], $nonce['action'], $nonce['exp'] ?? null);
    }

    /**
     *
     */
    protected function request(ServerRequestInterface $request): ServerRequestInterface
    {
        return $request;
    }

    /**
     * @return FormDataProcessorInterface[]
     */
    protected function formDataProcessors(): array
    {
        return [];
    }

    /**
     * @return FormFieldControllerInterface[]
     */
    abstract protected function formFieldControllers(): array;

    /**
     * @return array
     */
    abstract protected function config(): array;
}
