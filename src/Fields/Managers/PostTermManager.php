<?php

namespace WebTheory\Leonidas\Fields\Managers;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;

class PostTermManager implements FieldDataManagerInterface
{
    /**
     *
     */
    protected $taxonomy;

    /**
     * @var bool
     */
    protected $appendNewTerms = false;

    /**
     *
     */
    public function __construct($taxonomy)
    {
        $this->taxonomy = $taxonomy;
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
    public function areNewTermsAppended(): bool
    {
        return $this->appendNewTerms;
    }

    /**
     * Set the value of appendNewTerms
     *
     * @param bool $appendNewTerms
     *
     * @return self
     */
    public function setAppendNewTerms(bool $appendNewTerms)
    {
        $this->appendNewTerms = $appendNewTerms;

        return $this;
    }

    /**
     *
     */
    public function getCurrentData(ServerRequestInterface $request)
    {
        return get_the_terms($request->getAttribute('post')->ID, $this->taxonomy);
    }

    /**
     *
     */
    public function handleSubmittedData(ServerRequestInterface $request, $data): bool
    {
        $post = $request->getAttribute('post');
        $original = $this->getCurrentData($post);

        try {
            $result = wp_set_post_terms($post->ID, $data, $this->taxonomy, $this->appendNewTerms);
        } catch (\WP_Error $e) {
            $result = null;
        }

        return isset($result) ? ($original !== $result ? true : false) : false;
    }
}
