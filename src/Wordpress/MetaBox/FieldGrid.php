<?php

namespace WebTheory\WordPress\MetaBox;

use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Controllers\FormFieldController;
use WebTheory\WordPress\MetaBox\Contracts\MetaboxContentInterface;
use WebTheory\WordPress\Traits\UsesTemplateTrait;

class FieldGrid implements MetaboxContentInterface
{
    use UsesTemplateTrait;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $rows = [];

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $map = [];

    /**
     * @var int
     */
    private $columnCount = 0;

    /**
     * @var int
     */
    protected $columnWidth;

    /**
     * @var int
     */
    protected $rowPadding = 2;

    /**
     * @var int|bool
     */
    protected $endOffset = true;

    /**
     * @var int|bool
     */
    protected $startOffset = false;

    /**
     *
     */
    private $template = 'metabox__field-grid';

    /**
     * The following constants are used define the maximum allowed field columns
     * with the limitation being determined by the css grid system used to style
     * the template minus the width of the column designated for displaying the
     * row labels
     */
    private const MAX_COLUMNS = 12;
    private const ROW_TITLE_COL_WITDH = 2;
    private const MAX_FIELD_COLUMNS = self::MAX_COLUMNS - self::ROW_TITLE_COL_WITDH;

    /**
     * Get the value of columns
     *
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Set the value of columns
     *
     * @param array $columns
     *
     * @return self
     */
    public function setColumns(array $columns)
    {
        foreach ($columns as $slug => $options) {
            $this->addColumn($slug, $options['name'] ?? $options, $options['width'] ?? null);
        }

        return $this;
    }

    /**
     * Set the value of columns
     *
     * @param array $columns
     *
     * @return self
     */
    public function addColumn(string $slug, string $label, int $width = null)
    {
        $maxColumns = static::MAX_FIELD_COLUMNS;

        if ($maxColumns > $this->columnCount) {
            $this->columnCount++;
            $this->columns[$slug] = ['label' => $label, 'width' => $width];
        } else {
            // throw new \Exception("Column count cannot exceed {$maxColumns}");
            trigger_error("Column count should not exceed {$maxColumns}", E_USER_WARNING);
        }

        return $this;
    }

    /**
     *
     */
    public function getColumnCount()
    {
        return $this->columnCount;
    }

    /**
     * Get the value of rows
     *
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * Set the value of rows
     *
     * @param array $rows
     *
     * @return self
     */
    public function setRows(array $rows)
    {
        foreach ($rows as $slug => $label) {
            $this->addRow($slug, $label);
        }

        return $this;
    }

    /**
     * Set the value of rows
     *
     * @param array $rows
     *
     * @return self
     */
    public function addRow(string $slug, string $label)
    {
        $this->rows[$slug] = $label;

        return $this;
    }

    /**
     * Get the value of fields
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Set the value of fields
     *
     * @param array $fields
     *
     * @return self
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->addField($field['row'], $field['col'], $field['field']);
        }

        return $this;
    }

    /**
     * Set the value of fields
     *
     * @param array $fields
     *
     * @return self
     */
    public function addField(string $row, string $col, FormFieldController $field)
    {
        $this->fields[] = $field;
        $this->map[$row][$col] = $field->getFormField();

        return $this;
    }

    /**
     * Get the value of columnWidth
     *
     * @return int
     */
    public function getColumnWidth(): int
    {
        return $this->columnWidth;
    }

    /**
     * Set the value of columnWidth
     *
     * @param int $columnWidth
     *
     * @return self
     */
    public function setColumnWidth(int $columnWidth)
    {
        $this->columnWidth = $columnWidth;

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
     * Get the value of endOffset
     *
     * @return int|bool
     */
    public function getEndOffset()
    {
        return $this->endOffset;
    }

    /**
     * Set the value of endOffset
     *
     * @param int|bool $endOffset
     *
     * @return self
     */
    public function setEndOffset($endOffset)
    {
        $this->endOffset = $endOffset;

        return $this;
    }

    /**
     * Get the value of startOffset
     *
     * @return int|bool
     */
    public function getStartOffset()
    {
        return $this->startOffset;
    }

    /**
     * Set the value of startOffset
     *
     * @param int|bool $startOffset
     *
     * @return self
     */
    public function setStartOffset($startOffset)
    {
        $this->startOffset = $startOffset;

        return $this;
    }

    /**
     *
     */
    public function render($post)
    {
        /** @var FormFieldControllerInterface $field */
        foreach ($this->fields as $field) {
            // triggers field controller to set formfield dynamic value
            $field->renderFormField($post);
        }

        return $this->renderTemplate([
            'map' => $this->map,
            'rows' => $this->rows,
            'columns' => $this->columns,
            'row_padding' => $this->rowPadding,
            'row_root_width' => static::ROW_TITLE_COL_WITDH,
            'col_width' => isset($this->columnWidth) ? "-{$this->columnWidth}" : null,
        ]);
    }
}
