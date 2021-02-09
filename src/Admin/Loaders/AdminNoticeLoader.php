<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Admin\Contracts\AdminNoticeInterface;

class AdminNoticeLoader
{
    /**
     * @var AdminNoticeInterface[]
     */
    protected static $notices = [];

    /**
     * @var string
     */
    protected const TRANSIENT = 'leonidas.adminNotices';

    /**
     *
     */
    public static function hook()
    {
        add_action('admin_notices', [static::class, 'renderNotices']);
        add_action('wp_redirect', [static::class, 'setTransient']);
    }

    /**
     *
     */
    public static function addNotice(AdminNoticeInterface $notice)
    {
        static::$notices[] = $notice;
    }

    /**
     *
     */
    final public static function setTransient()
    {
        if (is_admin() && static::$notices) {
            set_transient(static::TRANSIENT, static::$notices, 300);
        }

        return func_get_arg(0);
    }

    /**
     *
     */
    public static function renderNotices()
    {
        /** @var AdminNoticeInterface[] $notices */
        $notices = get_transient(static::TRANSIENT);

        if (!$notices) {
            return;
        }

        $request = ServerRequest::fromGlobals();

        foreach ($notices as $notice) {
            if ($notice->shouldBeRendered($request))
                $notice->renderComponent($request);
        }

        delete_transient(static::TRANSIENT);
    }
}
