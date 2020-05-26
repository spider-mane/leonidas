<?php

namespace WebTheory\Leonidas\Forms\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Modules\AdminNotice;
use WebTheory\Saveyour\Controllers\FormProcessingCache;
use WebTheory\Saveyour\Controllers\FormSubmissionManager;

abstract class AbstractWpAdminFormSubmissionManager extends FormSubmissionManager
{
    /**
     *
     */
    protected $nonce = [];

    /**
     *
     */
    protected function hook()
    {
        return $this;
    }

    /**
     *
     */
    public function setNonce(string $name, string $action)
    {
        $this->nonce['name'] = $name;
        $this->nonce['action'] = $action;

        return $this;
    }

    /**
     *
     */
    protected function processResults(ServerRequestInterface $request, FormProcessingCache $cache)
    {
        $fields = array_filter($cache->inputViolations());

        if ($fields) {
            foreach ($fields as $alerts) {
                foreach ($alerts as $alert) {
                    (new AdminNotice($alert))->setDismissible(false)->register();
                }
            }
        }

        return $this;
    }

    /**
     *
     */
    protected function formHasValidNonce(): bool
    {
        $nonceName = $this->nonce['name'] ?? null;
        $nonceAction = $this->nonce['action'] ?? null;

        if (
            !isset($nonceName, $nonceAction, $_POST[$nonceName])
            || !wp_verify_nonce($_POST[$nonceName], $nonceAction)
        ) {
            return false;
        }

        return true;
    }
}
