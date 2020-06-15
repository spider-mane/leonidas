<?php

namespace WebTheory\Leonidas\Term;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Traits\HasNonceTrait;

class FieldLoader
{
    use HasNonceTrait;

    /**
     * @var string
     */
    protected $taxonomy;

    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     *
     */
    protected $screens = [
        'edit' => true,
        'add' => true
    ];

    /**
     *
     */
    public function __construct(string $taxonomy, Field ...$fields)
    {
        $this->taxonomy = $taxonomy;
        $this->fields = $fields;
    }

    /**
     * Get the value of taxonomy
     *
     * @return string
     */
    public function getTaxonomy(): string
    {
        return $this->taxonomy;
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
     *
     */
    public function addField(Field $field)
    {
        $this->fields = $field;
    }

    /**
     *
     */
    public function hook()
    {
        if (true === $this->screens['edit']) {
            add_action("{$this->taxonomy}_edit_form_fields", [$this, 'renderFields'], null, 1);
        }

        if (true === $this->screens['add']) {
            add_action("{$this->taxonomy}_add_form_fields", [$this, 'renderFields'], null, 0);
        }

        return $this;
    }

    /**
     * @return void
     */
    public function renderFields($term = null)
    {
        $request = ServerRequest::fromGlobals();
        $term && $request = $request->withAttribute('term', $term);

        $html = '';
        $html .= isset($this->nonce) ? $this->nonce->field() . "\n" : '';

        foreach ($this->fields as $field) {
            $html .= $field->render($request) . "\n";
        }

        echo $html;
    }
}
