<?php

namespace Leonidas\Library\Admin\Field\Data;

use Leonidas\Library\System\Request\Abstracts\ExpectsPostEntityTrait;
use Leonidas\Library\System\Schema\Term\TermCollection;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\Data\FieldDataManagerInterface;

class PostTermDataManager implements FieldDataManagerInterface
{
    use ExpectsPostEntityTrait;

    protected string $taxonomy;

    protected bool $appendNewTerms = false;

    public function __construct(string $taxonomy, bool $appendNewTerms = false)
    {
        $this->taxonomy = $taxonomy;
        $this->appendNewTerms = $appendNewTerms;
    }

    /**
     * Get the value of taxonomy
     *
     * @return mixed
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }

    /**
     * Get the value of appendNewTerms
     *
     * @return bool
     */
    public function newTermsAppended(): bool
    {
        return $this->appendNewTerms;
    }

    public function getCurrentData(ServerRequestInterface $request)
    {
        return get_the_terms($this->getPostId($request), $this->taxonomy) ?: [];
    }

    public function handleSubmittedData(ServerRequestInterface $request, $terms): bool
    {
        $old = new TermCollection(...$this->getCurrentData($request));

        wp_set_post_terms(
            $this->getPostId($request),
            $terms,
            $this->taxonomy,
            $this->appendNewTerms
        );

        $new = new TermCollection(...$this->getCurrentData($request));

        return $old->isDiff($new);
    }
}
