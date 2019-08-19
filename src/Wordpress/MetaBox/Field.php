<?php

namespace Backalley\WordPress\MetaBox;

use Backalley\Wordpress\Traits\UsesTemplateTrait;
use Backalley\Form\Contracts\FormFieldControllerInterface;
use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;

class Field implements MetaboxContentInterface
{
    use UsesTemplateTrait;

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
     * @var int
     */
    protected $rowPadding = 3;

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
    private $template = 'metabox__field';

    /**
     *
     */
    private const ROW_TITLE_COL_WITDH = 2;

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
     * Get the value of rowPadding
     *
     * @return int
     */
    public function getRowPadding(): int
    {
        return $this->rowPadding;
    }

    /**
     * Set the value of rowPadding
     *
     * @param int $rowPadding
     *
     * @return self
     */
    public function setRowPadding(int $rowPadding)
    {
        $this->rowPadding = $rowPadding;

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
    protected function renderFormField($post)
    {
        return $this->formFieldController->renderFormField($post);
    }

    /**
     *
     */
    public function render($post)
    {
        return $this->renderTemplate([
            'label' => $this->label,
            'hidden' => $this->hiddenInput,
            'row_padding' => $this->rowPadding,
            'description' => $this->description,
            'submit_button' => $this->submitButton,
            'field' => $this->renderFormField($post),
            'root_width' => static::ROW_TITLE_COL_WITDH,
        ]);
    }
}
