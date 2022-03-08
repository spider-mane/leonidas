<?php

namespace Leonidas\Traits;

use Psr\Http\Message\ServerRequestInterface;
use WP_Term;

trait ExpectsTermTrait
{
    protected function getTerm(ServerRequestInterface $request): ?WP_Term
    {
        return $request->getAttribute('term');
    }

    protected function getTermId(ServerRequestInterface $request): ?int
    {
        $term = $this->getTerm($request);

        return $term ? $term->term_id : null;
    }
}
