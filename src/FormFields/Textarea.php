<?php

namespace Backalley\FormFields;

use Backalley\FormFields\Contracts\FormFieldInterface;

class Textarea extends AbstractField implements FormFieldInterface
{
    /**
     *
     */
    public $content = '';

    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        $html = '';

        $html .= $this->open('textarea', $this->attributes);
        $html .= $this->content;
        $html .= $this->close('textarea');

        return $html;
    }

    /**
     *
     */
    public function parse_args($args)
    {
        $this->content = $args['content'] ?? $this->content;

        return $this;
    }
}
