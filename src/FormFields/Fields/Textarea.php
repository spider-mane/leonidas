<?php

namespace Backalley\FormFields\Fields;

use Backalley\FormFields\Contracts\FormFieldInterface;

class Textarea extends AbstractFormField implements FormFieldInterface
{
    /**
     * @var int
     */
    public $rows;

    /**
     * Get the value of rows
     *
     * @return int
     */
    public function getRows(): int
    {
        return $this->rows;
    }

    /**
     * Set the value of rows
     *
     * @param int $rows
     *
     * @return self
     */
    public function setRows(int $rows)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     *
     */
    protected function resolveAttributes()
    {
        return parent::resolveAttributes()
            ->addAttribute('rows', $this->rows);
    }

    /**
     *
     */
    public function toHtml()
    {
        $this->resolveAttributes();

        $html = '';

        $html .= $this->open('textarea', $this->attributes);
        $html .= $this->value;
        $html .= $this->close('textarea');

        return $html;
    }
}
