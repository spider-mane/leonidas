<?php

namespace Leonidas\Library\System\Request\Abstracts;

use Psr\Http\Message\ServerRequestInterface;
use WP_Term;

trait ExpectsTermEntityTrait
{
    protected function getTerm(ServerRequestInterface $request): ?WP_Term
    {
        return $request->getAttribute('term');
    }

    protected function getTermId(ServerRequestInterface $request): ?int
    {
        return ($term = $this->getTerm($request)) ? $term->term_id : null;
    }
}
