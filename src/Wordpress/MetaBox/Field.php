<?php

namespace WebTheory\WordPress\MetaBox;

use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\WordPress\Fields\AbstractField;
use WebTheory\WordPress\Traits\UsesTemplateTrait;
use WebTheory\WordPress\MetaBox\Contracts\MetaboxFieldInterface;

class Field extends AbstractField implements MetaboxFieldInterface
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
