<?php

namespace Backalley\Wordpress\Term;

use Backalley\Wordpress\Fields\AbstractField;
use Backalley\Wordpress\Traits\UsesTemplateTrait;

class Field extends AbstractField
{
    use UsesTemplateTrait;

    /**
     * @var WP_Taxonomy
     */
    protected $taxonomy;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $template;

    /**
     *
     */
    public function __construct(string $taxonomy, array $options = [])
    {
        $this->taxonomy = get_taxonomy($taxonomy);

        $this->setOptions($options);
    }

    /**
     * Get the value of taxonomy
     *
     * @return WP_Taxonomy
     */
    public function getTaxonomy(): WP_Taxonomy
    {
        return $this->taxonomy;
    }

    /**
     * Get the value of options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @param array $options
     *
     * @return self
     */
    protected function setOptions(array $options)
    {
        $this->options = array_merge([
            'add_term_field' => true,
            'edit_term_field' => true,
        ], $options);

        return $this;
    }

    /**
     *
     */
    public function hook()
    {
        if (true === $this->options['edit_term_field']) {
            add_action("{$this->taxonomy->name}_edit_form_fields", [$this, 'render'], null, 1);
        }

        if (true === $this->options['add_term_field']) {
            add_action("{$this->taxonomy->name}_add_form_fields", [$this, 'render'], null, 0);
        }
    }

    /**
     *
     */
    private function setTemplate()
    {
        switch (get_current_screen()->base) {

            case 'edit-tags':
                $template = 'term--add__field';
                break;

            case 'term':
                $template = 'term--edit__field';
                break;
        }

        $this->template = $template;

        return $this;
    }

    /**
     * @return void
     */
    public function render($term = null)
    {
        echo $this
            ->setTemplate()
            ->renderTemplate([
                'label' => $this->label,
                'description' => $this->description,
                'field' => $this->renderFormField($term)
            ]);
    }
}
