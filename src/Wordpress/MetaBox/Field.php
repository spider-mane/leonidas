<?php

namespace Backalley\WordPress\MetaBox;

use Timber\Timber;
use Backalley\FormFields\Contracts\FormFieldControllerInterface;
use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;

class Field implements MetaboxContentInterface
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
     * @var bool
     */
    protected $displayLabel = true;

    /**
     * @var string
     */
    protected $submitButton;

    /**
     * @var array
     */
    protected $hiddenInput;

    /**
     *
     */
    protected $template = 'metabox__field.twig';

    /**
     *
     */
    public function __construct($slug, FormFieldControllerInterface $formFieldController)
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
     * Get the value of displayLabel
     *
     * @return bool
     */
    public function getDisplayLabel(): bool
    {
        return $this->displayLabel;
    }

    /**
     * Set the value of displayLabel
     *
     * @param bool $displayLabel
     *
     * @return self
     */
    public function setDisplayLabel(bool $displayLabel)
    {
        $this->displayLabel = $displayLabel;

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
     * @param string  $description  description
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
    public function render($post)
    {
        $definition = [
            'label' => $this->label,
            'description' => $this->description,
            'field' => $this->renderFormField($post),
            'hidden' => $this->hiddenInput,
            'submit_button' => $this->submitButton,
        ];

        $this->renderTemplate($definition);
    }

    protected function renderFormField($post)
    {
        return $this->formFieldController->renderFormField($post);
    }

    /**
     *
     */
    protected function renderTemplate($context)
    {
        Timber::render($this->template, $context);
    }
}
