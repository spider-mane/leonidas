<?php

namespace WebTheory\Leonidas\Admin\Forms\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Notices\StandardAdminNotice;
use WebTheory\Saveyour\Controllers\FormProcessingCache;
use WebTheory\Saveyour\Controllers\FormSubmissionManager;

abstract class AbstractWpAdminFormSubmissionManager extends FormSubmissionManager
{
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
    protected function processResults(ServerRequestInterface $request, FormProcessingCache $cache)
    {
        $fields = array_filter($cache->inputViolations());

        if ($fields) {
            foreach ($fields as $alerts) {
                foreach ($alerts as $alert) {
                    (new StandardAdminNotice($alert))->setDismissible(false)->register();
                }
            }
        }

        return $this;
    }
}
