<?php

namespace Leonidas\Library\System\Request\Policy;

use Leonidas\Library\System\Request\Abstracts\ExpectsPostEntityTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WP_Post;

class PostEntityTermPolicy implements ServerRequestPolicyInterface
{
    use ExpectsPostEntityTrait;

    protected string $taxonomy;

    /**
     * @var array<int>
     */
    protected array $terms;

    protected bool $matchAll;

    public function __construct(string $taxonomy, bool $matchAll, int ...$terms)
    {
        $this->taxonomy = $taxonomy;
        $this->matchAll = $matchAll;
        $this->terms = $terms;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        $post = $this->getPost($request);

        return $this->matchAll ?
            $this->matchesAllTerms($post) :
            $this->matchesSingleTerm($post);
    }

    protected function matchesSingleTerm(WP_Post $post): bool
    {
        foreach ($this->terms as $term) {
            if (has_term($term, $this->taxonomy, $post)) {
                return true;
            }
        }

        return false;
    }

    protected function matchesAllTerms(WP_Post $post): bool
    {
        foreach ($this->terms as $term) {
            if (!has_term($term, $this->taxonomy, $post)) {
                return false;
            }
        }

        return true;
    }
}
