<?php

namespace Leonidas\Library\Admin\Forms\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use Leonidas\Library\Admin\Forms\Validators\CsrfCheck;
use Leonidas\Library\Admin\Forms\Validators\NoAutosave;
use Leonidas\Library\Admin\Forms\Validators\Permissions\EditTerm;
use Leonidas\Traits\MaybeHandlesCsrfTrait;
use WP_Taxonomy;

class TermFieldFormSubmissionManager extends AbstractWpAdminFormSubmissionManager
{
    use MaybeHandlesCsrfTrait;

    /**
     * @var WP_Taxonomy
     */
    protected $taxonomy;

    /**
     * @var array
     */
    protected $actions = [
        'edited' => true,
        'created' => true,
    ];

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
        foreach ($this->actions as $event => $enabled) {
            if ($enabled) {
                add_action(
                    "{$event}_{$this->taxonomy->name}",
                    [$this, 'processTermFields'],
                    null,
                    PHP_INT_MAX
                );
            }
        }

        return parent::hook();
    }

    /**
     *
     */
    public function processTermFields($termId, $ttId)
    {
        // $this->addDefaultFormValidators();

        $request = ServerRequest::fromGlobals()
            ->withAttribute('term', get_term($termId, $this->taxonomy->name, 'OBJECT'))
            ->withAttribute('term_id', $termId)
            ->withAttribute('tt_id', $ttId);

        $this->process($request);
    }

    /**
     *
     */
    protected function addDefaultFormValidators()
    {
        $this->addValidator('no_autosave', new NoAutosave());
        $this->addValidator('user_can_edit', new EditTerm());

        if (isset($this->csrfManager)) {
            $this->addValidator('invalid_request', new CsrfCheck($this->csrfManager));
        }
    }
}
