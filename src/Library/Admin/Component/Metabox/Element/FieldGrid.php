<?php

namespace Leonidas\Library\Admin\Component\Metabox\Element;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxComponentInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Leonidas\Library\Admin\Component\Metabox\View\FieldGridView;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Controller\FormFieldController;

class FieldGrid implements MetaboxComponentInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    /**
     * The following constants are used define the maximum allowed field columns
     * with the limitation being determined by the css grid system used to style
     * the template minus the width of the column designated for displaying the
     * row labels
     */
    protected const MAX_COLUMNS = 12;
    protected const ROW_TITLE_COL_WITDH = 2;
    protected const MAX_FIELD_COLUMNS = self::MAX_COLUMNS - self::ROW_TITLE_COL_WITDH;

    protected array $columns = [];

    protected array $rows = [];

    /**
     * @var FormFieldControllerInterface[]
     */
    protected array $fields = [];

    protected array $map = [];

    private int $columnCount = 0;

    protected ?int $columnWidth = null;

    protected int $rowPadding = 2;

    /**
     * @var int|bool
     */
    protected $endOffset = true;

    /**
     * @var int|bool
     */
    protected $startOffset = false;

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function setColumns(array $columns)
    {
        foreach ($columns as $slug => $options) {
            $this->addColumn($slug, $options['name'] ?? $options, $options['width'] ?? null);
        }

        return $this;
    }

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

    public function getColumnCount()
    {
        return $this->columnCount;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function setRows(array $rows)
    {
        foreach ($rows as $slug => $label) {
            $this->addRow($slug, $label);
        }

        return $this;
    }

    public function addRow(string $slug, string $label)
    {
        $this->rows[$slug] = $label;

        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->addField($field['row'], $field['col'], $field['field']);
        }

        return $this;
    }

    public function addField(string $row, string $col, FormFieldController $field)
    {
        $this->fields[] = $field;
        $this->map[$row][$col] = $field->getFormField();

        return $this;
    }

    public function getColumnWidth(): int
    {
        return $this->columnWidth;
    }

    public function setColumnWidth(int $columnWidth)
    {
        $this->columnWidth = $columnWidth;

        return $this;
    }

    public function getRowPadding(): int
    {
        return $this->rowPadding;
    }

    public function setRowPadding(int $rowPadding)
    {
        $this->rowPadding = $rowPadding;

        return $this;
    }

    public function getEndOffset()
    {
        return $this->endOffset;
    }

    public function setEndOffset($endOffset)
    {
        $this->endOffset = $endOffset;

        return $this;
    }

    public function getStartOffset()
    {
        return $this->startOffset;
    }

    public function setStartOffset($startOffset)
    {
        $this->startOffset = $startOffset;

        return $this;
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new FieldGridView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        $this->prepareFields($request);

        return [
            'map' => $this->map,
            'rows' => $this->rows,
            'columns' => $this->columns,
            'row_padding' => $this->rowPadding,
            'row_root_width' => static::ROW_TITLE_COL_WITDH,
            'col_width' => isset($this->columnWidth) ? "-{$this->columnWidth}" : null,
        ];
    }

    protected function prepareFields(ServerRequestInterface $request): void
    {
        foreach ($this->fields as $field) {
            $field->compose($request);
        }
    }
}
