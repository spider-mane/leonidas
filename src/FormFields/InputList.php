<?php

namespace Backalley\FormFields;

use Backalley\FormFields\Contracts\FormFieldInterface;


class InputList extends AbstractField implements FormFieldInterface
{
    /**
     * input_type
     *
     * @var string
     */
    public $input_type = '';

    /**
     * items
     *
     * @var array
     */
    public $items = [];

    /**
     *
     */
    public $ul = [];

    /**
     *
     */
    public function __toString()
    {
        $html = '';

        $html .= $this->open('div', $this->attributes ?? null);
        $html .= $this->open('ul', $this->ul['attributes'] ?? null);

        foreach ($this->items as $item) {
            $li = $item['li'] ?? null;
            $label = $item['label'] ?? null;
            $toggle = $item['toggle'] ?? null;

            // opening tag for list item
            $html .= $this->open('li', $li['attributes'] ?? null);

            // toggle control and/or and item
            $html .= $this->open('input', $item['attributes'] ?? null);

            // create label
            $html .= $this->open('label', $label['attributes'] ?? null);
            $html .= $label['content'] ?? '';
            $html .= $this->close('label');

            // close li
            $html .= $this->close('li');
        }

        $html .= $this->close('ul');
        $html .= $this->close('div');

        return $html;
    }

    /**
     *
     */
    protected function parse_args($args)
    {
        $this->ul = $args['ul'] ?? $this->ul;
        $this->items = $args['items'];

        $this->define_items_type();
    }

    /**
     *
     */
    protected function define_items_type()
    {
        foreach ($this->items as &$item) {
            $item['attributes']['type'] = $this->input_type;
        }
    }
}
