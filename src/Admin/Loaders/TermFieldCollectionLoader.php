<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Admin\Contracts\ComponentLoaderInterface;
use WebTheory\Leonidas\Admin\Contracts\TermFieldInterface;
use WebTheory\Leonidas\Core\Traits\HasNonceTrait;

class TermFieldCollectionLoader implements ComponentLoaderInterface
{
    use HasNonceTrait;

    /**
     * @var string
     */
    protected $taxonomy;

    /**
     * @var TermFieldInterface[]
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
    public function __construct(string $taxonomy, TermFieldInterface ...$fields)
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
    public function addField(TermFieldInterface $field)
    {
        $this->fields = $field;
    }

    /**
     *
     */
    public function hook()
    {
        if (true === $this->screens['edit']) {
            $this->targetTaxonomyEditFormFieldsHook();
        }

        if (true === $this->screens['add']) {
            $this->targetTaxonomyAddFormFieldsHook();
        }

        return $this;
    }

    protected function targetTaxonomyEditFormFieldsHook(): TermFieldCollectionLoader
    {
        add_action("{$this->taxonomy}_edit_form_fields", [$this, 'renderFields'], null, 1);

        return $this;
    }

    protected function targetTaxonomyAddFormFieldsHook(): TermFieldCollectionLoader
    {
        add_action("{$this->taxonomy}_add_form_fields", [$this, 'renderFields'], null, 0);

        return $this;
    }

    /**
     * @return void
     */
    public function renderFields($term = null): void
    {
        $request = ServerRequest::fromGlobals();
        $term && $request = $request->withAttribute('term', $term);

        $html = '';
        $html .= $this->maybeRenderNonce();

        foreach ($this->fields as $field) {
            if ($field->shouldBeRendered($request)) {
                $html .= $field->renderComponent($request) . "\n";
            }
        }

        echo $html;
    }
}
