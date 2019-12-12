<?php

namespace WebTheory\Leonidas\Term;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Fields\AbstractField;
use WebTheory\Leonidas\Fields\WpAdminField;
use WebTheory\Leonidas\Traits\UsesTemplateTrait;

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
    protected $options = [
        'add_term_field' => true,
        'edit_term_field' => true,
    ];

    /**
     * @var string
     */
    protected $template;

    /**
     *
     */
    public function __construct(string $taxonomy, WpAdminField $formFieldController, array $options = [])
    {
        $this->taxonomy = get_taxonomy($taxonomy);

        parent::__construct($formFieldController);

        if (!empty($options)) {
            $this->setOptions($options);
        }
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
        $this->options = $options + $this->options;

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

        return $this;
    }

    /**
     *
     */
    protected function setTemplate()
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
        $request = ServerRequest::fromGlobals();

        echo $this->setTemplate()
            ->renderTemplate([
                'label' => $this->label,
                'description' => $this->description,
                'field' => $this->renderFormField(
                    $term ? $request->withAttribute('term', $term) : $request
                )
            ]);
    }
}