<?php

namespace WebTheory\Leonidas\MetaBox;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Fields\AbstractField;
use WebTheory\Leonidas\MetaBox\Contracts\MetaboxFieldInterface;
use WebTheory\Leonidas\Traits\ExpectsPostTrait;
use WebTheory\Leonidas\Traits\UsesTemplateTrait;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;

class Field extends AbstractField implements MetaboxFieldInterface
{
    use ExpectsPostTrait;
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
    private const ROW_TITLE_COL_WIDTH = 2;

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
    public function render(ServerRequestInterface $request): string
    {
        return $this->renderTemplate([
            'label' => $this->label,
            'hidden' => $this->hiddenInput,
            'row_padding' => $this->rowPadding,
            'description' => $this->description,
            'submit_button' => $this->submitButton,
            'field' => $this->renderFormField($request),
            'root_width' => static::ROW_TITLE_COL_WIDTH,
        ]);
    }
}
