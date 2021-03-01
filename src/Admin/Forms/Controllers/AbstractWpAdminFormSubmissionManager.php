<?php

namespace WebTheory\Leonidas\Admin\Forms\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminNoticeCollectionLoaderInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminNoticeInterface;
use WebTheory\Leonidas\Admin\Loaders\AdminNoticeCollectionLoader;
use WebTheory\Leonidas\Admin\Notices\Components\StandardAdminNotice;
use WebTheory\Saveyour\Controllers\FormProcessingCache;
use WebTheory\Saveyour\Controllers\FormSubmissionManager;

abstract class AbstractWpAdminFormSubmissionManager extends FormSubmissionManager
{
    /**
     * @var AdminNoticeCollectionLoaderInterface
     */
    protected $adminNoticeLoader;

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
    public function __construct(AdminNoticeCollectionLoaderInterface $adminNoticeLoader)
    {
        $this->adminNoticeLoader = $adminNoticeLoader;
    }

    /**
     *
     */
    protected function processResults(ServerRequestInterface $request, FormProcessingCache $cache)
    {
        $fields = array_filter($cache->inputViolations());

        if ($fields) {
            foreach ($fields as $messages) {
                foreach ($messages as $message) {
                    $this->registerAdminNotice($message);
                }
            }
        }

        return $this;
    }

    /**
     *
     */
    protected function registerAdminNotice(string $message)
    {
        $this->adminNoticeLoader->addNotice($this->defineAdminNotice($message));
    }

    /**
     *
     */
    protected function defineAdminNotice(string $message): AdminNoticeInterface
    {
        return (new StandardAdminNotice($message))->setDismissible(false);
    }
}
