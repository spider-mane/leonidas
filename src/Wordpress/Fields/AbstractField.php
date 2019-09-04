<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Form\Contracts\FormFieldControllerInterface;
use Backalley\Form\Contracts\FormFieldInterface;

class AbstractField
{
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
        $this->setFormFieldController($formFieldController);
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
     * Set the value of formFieldController
     *
     * @param FormFieldControllerInterface $formFieldController
     *
     * @return self
     */
    public function setFormFieldController(FormFieldControllerInterface $formFieldController)
    {
        $this->formFieldController = $formFieldController;

        return $this;
    }

    /**
     *
     */
    protected function renderFormField($object): FormFieldInterface
    {
        return $this->formFieldController->renderFormField($object);
    }
}
