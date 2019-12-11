<?php

namespace WebTheory\Leonidas\Forms\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use WP_Taxonomy;
use WebTheory\Leonidas\Forms\Controllers\AbstractWpAdminFormSubmissionManager;

class TermFieldFormSubmissionManager extends AbstractWpAdminFormSubmissionManager
{
    /**
     * @var WP_Taxonomy
     */
    protected $taxonomy;

    /**
     * {@inheritDoc}
     */
    protected const TRANSIENT__RULE_VIOLATION = 'leonidas.term.field.ruleViolation';

    /**
     *
     */
    public function __construct(string $taxonomy)
    {
        $this->taxonomy = get_taxonomy($taxonomy);
    }

    /**
     * Get the value of taxonomy
     *
     * @return WP_Taxonomy
     */
    public function getTaxonomy(): WP_Taxonomy
    {
        return $this->taxonomy;
    }

    /**
     *
     */
    public function hook()
    {
        foreach (['edited', 'create'] as $event) {
            add_action("{$event}_{$this->taxonomy->name}", [$this, 'saveTermActionCallback'], null, 1);
        }

        return parent::hook();
    }

    /**
     *
     */
    public function saveTermActionCallback($termId)
    {
        if ($this->isSafeToRun($termId)) {

            $term = get_term($termId, $this->taxonomy->name, 'OBJECT');
            $request = ServerRequest::fromGlobals()
                ->withAttribute('term', $term)
                ->withAttribute('term_id', $termId);

            $this->process($request);
        }
    }

    /**
     *
     */
    public function isSafeToRun($termId)
    {
        if (!current_user_can('manage_categories', $termId)) {
            return false;
        }

        return true;
    }
}
