<?php

namespace WebTheory\Leonidas\Library\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use WP_Term;
use WebTheory\Leonidas\Contracts\Admin\Components\ComponentLoaderInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\TermFieldInterface;
use WebTheory\Leonidas\Traits\MaybeHandlesCsrfTrait;

class TermFieldCollectionLoader implements ComponentLoaderInterface
{
    use MaybeHandlesCsrfTrait;

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
        add_action("{$this->taxonomy}_edit_form_fields", [$this, 'renderFieldsOnEdit'], null, PHP_INT_MAX);

        return $this;
    }

    protected function targetTaxonomyAddFormFieldsHook(): TermFieldCollectionLoader
    {
        add_action("{$this->taxonomy}_add_form_fields", [$this, 'renderFieldsOnAdd'], null, PHP_INT_MAX);

        return $this;
    }

    public function renderFieldsOnEdit(WP_Term $term, string $taxonomy): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('term', $term)
            ->withAttribute('taxonomy', $taxonomy)
            ->withAttribute('context', $this->getScreenContext());

        echo $this->renderFields($request);
    }

    public function renderFieldsOnAdd(string $taxonomy): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('taxonomy', $taxonomy)
            ->withAttribute('context', $this->getScreenContext());

        echo $this->renderFields($request);
    }

    /**
     * @return void
     */
    protected function renderFields(ServerRequestInterface $request): string
    {
        $html = '';

        foreach ($this->fields as $field) {
            if ($field->shouldBeRendered($request)) {
                $html .= $field->renderComponent($request) . "\n";
            }
        }

        return $html;
    }

    protected function getServerRequest(): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }

    protected function getScreenContext()
    {
        return get_current_screen()->base;
    }
}
