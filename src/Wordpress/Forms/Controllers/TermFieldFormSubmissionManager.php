<?php

namespace Backalley\Wordpress\Forms\Controllers;

use Backalley\Form\Controllers\AbstractFormSubmissionManager;

class TermFieldFormSubmissionManager extends AbstractFormSubmissionManager
{
    /**
     * @var WP_Taxonomy
     */
    protected $taxonomy;

    /**
     *
     */
    public function __construct(string $taxonomy)
    {
        $this->taxonomy = get_taxonomy($taxonomy);
    }

    /**
     *
     */
    public function hook()
    {
        add_action("edited_{$this->taxonomy->name}", [$this, 'saveTermActionCallback'], null, 1);
        add_action("create_{$this->taxonomy->name}", [$this, 'saveTermActionCallback'], null, 1);
    }

    public function saveTermActionCallback($termId)
    {
        $this->handleRequest(get_term($termId, $this->taxonomy->name, 'OBJECT'));
    }

    protected function finalizeRequest($request)
    {
        return;
    }
}
