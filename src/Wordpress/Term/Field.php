<?php

namespace Backalley\Wordpress\Term;

use Backalley\Wordpress\Fields\AbstractField;
use Backalley\Wordpress\Traits\UsesTemplateTrait;

class Field extends AbstractField
{
    use UsesTemplateTrait;

    /**
     *
     */
    protected $template;

    /**
     *
     */
    private function setTemplate()
    {
        switch (get_current_screen()->base) {
            case 'term':
                $template = 'term--add__field';

            case 'edit-tags':
                $template = 'term--edit__field';
        }

        $this->template = $template;
    }

    /**
     * render
     *
     * @param WP_Term $term
     *
     * @return void
     */
    public function render($term)
    {
        $this->setTemplate();

        return $this->renderTemplate([
            'label' => $this->label,
            'description' => $this->description,
            'field' => $this->renderFormField($term)
        ]);
    }
}
