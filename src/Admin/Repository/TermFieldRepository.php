<?php

namespace WebTheory\Leonidas\Admin\Repository;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\ComponentLoaderInterface;
use WebTheory\Leonidas\Admin\Contracts\TermFieldInterface;
use WebTheory\Leonidas\Core\Traits\HasNonceTrait;

class TermFieldRepository
{
    use HasNonceTrait;

    /**
     * @var TermFieldInterface[]
     */
    protected $fields = [];

    /**
     *
     */
    public function __construct(string $taxonomy, TermFieldInterface ...$fields)
    {
        $this->taxonomy = $taxonomy;
        array_map([$this, 'addField'], $fields);
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

    public function getField(string $id)
    {
        return $this->fields[$id];
    }

    /**
     *
     */
    public function addField(TermFieldInterface $field)
    {
        $this->fields[$field->getId()] = $field;
    }

    /**
     * @return void
     */
    public function renderFields(string $taxonomy, ServerRequestInterface $request): void
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
