<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminNoticeCollectionLoaderInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\ComponentLoaderInterface;

class AdminNoticeCollectionLoader implements AdminNoticeCollectionLoaderInterface
{
    /**
     * @var AdminNoticeInterface[]
     */
    protected $notices = [];

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     *
     */
    protected const CACHE_TTL = 300;

    /**
     *
     */
    public function __construct(string $cacheKey, AdminNoticeInterface ...$notices)
    {
        $this->cacheKey = $cacheKey;
        $this->notices = $notices;
    }

    /**
     * Get the value of notices
     *
     * @return AdminNoticeInterface[]
     */
    public function getNotices(): array
    {
        return $this->notices;
    }

    /**
     *
     */
    public function hasNotices(): bool
    {
        return !empty($this->notices);
    }

    /**
     *
     */
    public function addNotice(AdminNoticeInterface $notice)
    {
        $this->notices[] = $notice;

        return $this;
    }

    /**
     *
     */
    protected function addNotices(AdminNoticeInterface ...$notices)
    {
        foreach ($notices as $notice) {
            $this->addNotice($notice);
        }

        return $this;
    }

    /**
     * Get the value of cacheKey
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        return $this->cacheKey;
    }

    /**
     *
     */
    public function hook()
    {
        $this->targetAdminNoticesHook()->targetWpRedirectHook();

        return $this;
    }

    protected function targetAdminNoticesHook(): AdminNoticeCollectionLoader
    {
        add_action('admin_notices', $this->getRenderNoticesCallback());

        return $this;
    }

    protected function targetWpRedirectHook(): AdminNoticeCollectionLoader
    {
        add_filter('wp_redirect', $this->getCacheNoticesCallback()); //! FILTER HOOK! first argument must be returned by callback

        return $this;
    }

    /**
     *
     */
    protected function getCacheNoticesCallback()
    {
        return function () {
            if (is_admin() && $this->hasNotices()) {
                set_transient($this->getCacheKey(), $this->getNotices(), static::CACHE_TTL);
            }

            return func_get_arg(0); // required because 'wp_redirect' is a filter hook
        };
    }

    /**
     *
     */
    protected function getRenderNoticesCallback()
    {
        return function () {
            /** @var AdminNoticeInterface[] $notices */
            $notices = get_transient($this->getCacheKey());

            if (!$notices) {
                return;
            }

            $output = '';
            $request = ServerRequest::fromGlobals();

            foreach ($notices as $notice) {
                if ($notice->shouldBeRendered($request))
                    $output .= $notice->renderComponent($request);
            }

            delete_transient($this->getCacheKey());

            echo $output;
        };
    }
}
