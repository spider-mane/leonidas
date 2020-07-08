<?php

namespace WebTheory\Leonidas\Constrainers;

use Psr\Http\Message\ServerRequestInterface;
use WP_Post;
use WP_Term;
use WebTheory\Leonidas\Contracts\ComponentConstrainerInterface;
use WebTheory\Leonidas\Traits\ExpectsPostTrait;

class PostTermConstrainer implements ComponentConstrainerInterface
{
    use ExpectsPostTrait;

    /**
     * @var string
     */
    protected $taxonomy;

    /**
     * @var WP_Term[]
     */
    protected $terms = [];

    /**
     * @var bool
     */
    protected $matchAll = false;

    /**
     *
     */
    public function __construct(string $taxonomy, int ...$terms)
    {
        $this->taxonomy = $taxonomy;
        $this->terms = $terms;
    }

    /**
     * Get the value of terms
     *
     * @return array
     */
    public function getTerms(): array
    {
        return $this->terms;
    }

    /**
     *
     */
    public function addTerm(int $term)
    {
        $this->terms[] = $term;
    }

    /**
     * Get the value of matchAll
     *
     * @return bool
     */
    public function shouldMatchAll(): bool
    {
        return $this->matchAll;
    }

    /**
     * Set the value of matchAll
     *
     * @param bool $matchAll
     *
     * @return self
     */
    public function setMatchAll(bool $matchAll)
    {
        $this->matchAll = $matchAll;

        return $this;
    }

    /**
     *
     */
    public function screenMeetsCriteria(ServerRequestInterface $request)
    {
        $post = $this->getPost($request);

        return $this->matchAll ?
            $this->matchesAllTerms($post) :
            $this->matchesSingleTerm($post);
    }

    /**
     *
     */
    protected function matchesSingleTerm(WP_Post $post): bool
    {
        foreach ($this->terms as $term) {
            if (has_term($term, $this->taxonomy, $post)) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     */
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
