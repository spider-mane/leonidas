<?php

namespace WebTheory\Leonidas\Fields;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Contracts\WpAdminFieldInterface;
use WebTheory\Leonidas\Traits\CanBeRestrictedTrait;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;

class AbstractField implements WpAdminFieldInterface
{
    use CanBeRestrictedTrait;

    /**
     * label
     *
     * @var string
     */
    protected $label;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * @var FormFieldControllerInterface
     */
    protected $formFieldController;

    /**
     *
     */
    public function __construct(FormFieldControllerInterface $formFieldController)
    {
        $this->formFieldController = $formFieldController;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set label
     *
     * @param string  $label  label
     *
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description description
     *
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of formFieldController
     *
     * @return FormFieldControllerInterface
     */
    public function getFormFieldController(): FormFieldControllerInterface
    {
        return $this->formFieldController;
    }

    /**
     *
     */
    protected function renderFormField(ServerRequestInterface $request): FormFieldInterface
    {
        return $this->formFieldController->render($request);
    }
}
