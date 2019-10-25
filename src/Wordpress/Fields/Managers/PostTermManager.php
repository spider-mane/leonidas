<?php

namespace WebTheory\WordPress\Fields\Managers;

use WebTheory\Form\Contracts\FieldDataManagerInterface;
use WebTheory\Form\Managers\AbstractFieldDataManager;

class PostTermManager extends AbstractFieldDataManager implements FieldDataManagerInterface
{
    /**
     *
     */
    private $taxonomy;

    /**
     * @var bool
     */
    private $newTermsAppended = false;

    /**
     * @var bool
     */
    private $commaSeparatedList = false;

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
     * Get the value of newTermsAppended
     *
     * @return bool
     */
    public function areNewTermsAppended(): bool
    {
        return $this->newTermsAppended;
    }

    /**
     * Set the value of newTermsAppended
     *
     * @param bool $newTermsAppended
     *
     * @return self
     */
    public function setNewTermsAppended(bool $newTermsAppended)
    {
        $this->newTermsAppended = $newTermsAppended;

        return $this;
    }

    /**
     * Get the value of commaSeparatedList
     *
     * @return bool
     */
    public function isCommaSeparatedList(): bool
    {
        return $this->commaSeparatedList;
    }

    /**
     * Set the value of commaSeparatedList
     *
     * @param bool $commaSeparatedList
     *
     * @return self
     */
    public function setCommaSeparatedList(bool $commaSeparatedList)
    {
        $this->commaSeparatedList = $commaSeparatedList;

        return $this;
    }

    /**
     *
     */
    public function getCurrentData($post)
    {
        return get_the_terms($post->ID, $this->taxonomy);
    }

    /**
     *
     */
    public function handleSubmittedData($post, $data): bool
    {
        $original = $this->getCurrentData($post);

        try {
            $result = wp_set_post_terms($post->ID, $data, $this->taxonomy, $this->newTermsAppended);
        } catch (\WP_Error $e) {
            $result = null;
        }

        return isset($result) ? ($original !== $result ? true : false) : false;
    }
}
