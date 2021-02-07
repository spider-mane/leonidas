<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use WebTheory\Leonidas\Admin\AdminNotice;

class AdminNoticeLoader
{
    /**
     * @var AdminNotice[]
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
        add_action('admin_notices', [static::class, 'render']);
        add_action('wp_redirect', [static::class, 'setTransient']);
    }

    /**
     *
     */
    public static function addNotice(AdminNotice $notice)
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
    public static function render()
    {
        /** @var AdminNotice[] $alerts */
        $alerts = get_transient(static::TRANSIENT);

        if ($alerts) {
            foreach ($alerts as $alert) {
                $alert->render();
            }

            delete_transient(static::TRANSIENT);
        }
    }
}
