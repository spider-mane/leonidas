<?php

namespace WebTheory\Leonidas\Admin\Metabox\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\AbstractAdminField;
use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxFieldInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Admin\Metabox\Views\FieldView;
use WebTheory\Leonidas\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Traits\RendersWithViewTrait;

class Field extends AbstractAdminField implements MetaboxFieldInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

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

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new FieldView();
    }

    /**
     *
     */
    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'label' => $this->label,
            'hidden' => $this->hiddenInput,
            'row_padding' => $this->rowPadding,
            'description' => $this->description,
            'submit_button' => $this->submitButton,
            'field' => $this->renderFormField($request),
            'root_width' => static::ROW_TITLE_COL_WIDTH,
        ];
    }
}
