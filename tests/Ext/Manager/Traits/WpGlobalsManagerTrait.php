<?php

namespace Tests\Ext\Manager\Traits;

use WP;
use WP_Query;

trait WpGlobalsManagerTrait
{
    public static function resetWpGlobals()
    {
        static::resetPostTypes();
        static::resetTaxonomies();
        static::resetWpQueryGlobal();
        static::resetWpGlobal();
        static::resetPostGlobals();
        static::resetCurrentScreenGlobals();
        static::resetWpScriptsGlobal();
        static::resetWpStylesGlobal();
        static::resetPostStatuses();
        static::unregisterAllMetaKeys();
        static::flushCache();
    }

    /**
     * Reset $wp_sitemap global so that sitemap-related dynamic
     * $wp->public_query_vars are added when the next test runs.
     */
    public static function resetWpSiteMapsGlobal()
    {
        $GLOBALS['wp_sitemaps'] = null;
    }

    public static function resetWpQueryGlobal()
    {
        $GLOBALS['wp_query'] = new WP_Query();
    }

    public static function resetWpGlobal()
    {
        $GLOBALS['wp'] = new WP();
    }

    public static $hooks_saved = [];

    /**
     * Cleans up any registered meta keys.
     *
     * @since 5.1.0
     *
     * @global array $wp_meta_keys
     */
    public static function unregisterAllMetaKeys()
    {
        global $wp_meta_keys;

        if (!is_array($wp_meta_keys)) {
            return;
        }

        foreach ($wp_meta_keys as $object_type => $type_keys) {
            foreach ($type_keys as $object_subtype => $subtype_keys) {
                foreach ($subtype_keys as $key => $value) {
                    unregister_meta_key($object_type, $key, $object_subtype);
                }
            }
        }
    }

    /**
     * Unregisters existing post types and register defaults.
     *
     * Run before each test in order to clean up the global scope, in case
     * a test forgets to unregister a post type on its own, or fails before
     * it has a chance to do so.
     */
    public static function resetPostTypes()
    {
        foreach (get_post_types([], 'objects') as $pt) {
            if (empty($pt->tests_no_auto_unregister)) {
                static::unregisterPostType($pt->name);
            }
        }
        create_initial_post_types();
    }

    /**
     * Unregisters existing taxonomies and register defaults.
     *
     * Run before each test in order to clean up the global scope, in case
     * a test forgets to unregister a taxonomy on its own, or fails before
     * it has a chance to do so.
     */
    public static function resetTaxonomies()
    {
        foreach (get_taxonomies() as $tax) {
            static::unregisterTaxonomy($tax);
        }
        create_initial_taxonomies();
    }

    /**
     * Unregisters non-built-in post statuses.
     */
    public static function resetPostStatuses()
    {
        foreach (get_post_stati(['_builtin' => false]) as $post_status) {
            static::unregisterPostStatus($post_status);
        }
    }

    /**
     * Saves the action and filter-related globals so they can be restored later.
     *
     * Stores $wp_actions, $wp_current_filter, and $wp_filter on a class variable
     * so they can be restored on tearDown() using _restore_hooks().
     *
     * @global array $wp_actions
     * @global array $wp_current_filter
     * @global array $wp_filter
     */
    public static function backupHooks()
    {
        $globals = ['wp_actions', 'wp_current_filter'];
        foreach ($globals as $key) {
            self::$hooks_saved[$key] = $GLOBALS[$key];
        }
        self::$hooks_saved['wp_filter'] = [];
        foreach ($GLOBALS['wp_filter'] as $hook_name => $hook_object) {
            self::$hooks_saved['wp_filter'][$hook_name] = clone $hook_object;
        }
    }

    /**
     * Restores the hook-related globals to their state at setUp()
     * so that future tests aren't affected by hooks set during this last test.
     *
     * @global array $wp_actions
     * @global array $wp_current_filter
     * @global array $wp_filter
     */
    public static function restoreHooks()
    {
        $globals = ['wp_actions', 'wp_current_filter'];
        foreach ($globals as $key) {
            if (isset(self::$hooks_saved[$key])) {
                $GLOBALS[$key] = self::$hooks_saved[$key];
            }
        }
        if (isset(self::$hooks_saved['wp_filter'])) {
            $GLOBALS['wp_filter'] = [];
            foreach (self::$hooks_saved['wp_filter'] as $hook_name => $hook_object) {
                $GLOBALS['wp_filter'][$hook_name] = clone $hook_object;
            }
        }
    }

    /**
     * Flushes the WordPress object cache.
     */
    public static function flushCache()
    {
        global $wp_object_cache;
        $wp_object_cache->group_ops = [];
        $wp_object_cache->stats = [];
        $wp_object_cache->memcache_debug = [];
        $wp_object_cache->cache = [];
        if (method_exists($wp_object_cache, '__remoteset')) {
            $wp_object_cache->__remoteset();
        }
        wp_cache_flush();
        wp_cache_add_global_groups(['users', 'userlogins', 'usermeta', 'user_meta', 'useremail', 'userslugs', 'site-transient', 'site-options', 'blog-lookup', 'blog-details', 'rss', 'global-posts', 'blog-id-cache', 'networks', 'sites', 'site-details', 'blog_meta']);
        wp_cache_add_non_persistent_groups(['comment', 'counts', 'plugins']);
    }

    // ADDED ===========================================================================================================

    /**
     * Reset globals related to the post loop and `setup_postdata()`.
     */
    public static function resetPostGlobals()
    {
        $post_globals = ['post', 'id', 'authordata', 'currentday', 'currentmonth', 'page', 'pages', 'multipage', 'more', 'numpages'];

        foreach ($post_globals as $global) {
            $GLOBALS[$global] = null;
        }
    }

    /**
     * Reset globals related to current screen to provide a consistent global starting state
     * for tests that interact with admin screens. Replaces the need for individual tests
     * to invoke `set_current_screen( 'front' )` (or an alternative implementation) as a reset.
     *
     * The globals are from `WP_Screen::set_current_screen()`.
     *
     * Why not invoke `set_current_screen( 'front' )`?
     * Performance (faster test runs with less memory usage). How so? For each test,
     * it saves creating an instance of WP_Screen, making two method calls,
     * and firing of the `current_screen` action.
     */
    public static function resetCurrentScreenGlobals()
    {
        $current_screen_globals = ['current_screen', 'taxnow', 'typenow'];
        foreach ($current_screen_globals as $global) {
            $GLOBALS[$global] = null;
        }
    }

    public static function resetWpScriptsGlobal()
    {
        global $wp_scripts;

        $wp_scripts = null;
    }

    public static function resetWpStylesGlobal()
    {
        global $wp_styles;

        $wp_styles = null;
    }

    /**
     * Resets permalinks and flushes rewrites.
     *
     * @since 4.4.0
     *
     * @global WP_Rewrite $wp_rewrite
     *
     * @param string $structure Optional. Permalink structure to set. Default empty.
     */
    public static function resetPermalinkStructure()
    {
        /** @var WP_Rewrite $wp_rewrite */
        global $wp_rewrite;

        $wp_rewrite->init();
        $wp_rewrite->set_permalink_structure('');
        $wp_rewrite->flush_rules();
    }

    /**
     * Removes the post type and its taxonomy associations.
     */
    public static function unregisterPostType($cpt_name)
    {
        unregister_post_type($cpt_name);
    }

    public static function unregisterTaxonomy($taxonomy_name)
    {
        unregister_taxonomy($taxonomy_name);
    }

    /**
     * Unregister a post status.
     *
     * @since 4.2.0
     *
     * @param string $status
     */
    public static function unregisterPostStatus($status)
    {
        unset($GLOBALS['wp_post_statuses'][$status]);
    }

    public static function cleanupQueryVars()
    {
        // Clean out globals to stop them polluting wp and wp_query.
        foreach ($GLOBALS['wp']->public_query_vars as $v) {
            unset($GLOBALS[$v]);
        }

        foreach ($GLOBALS['wp']->private_query_vars as $v) {
            unset($GLOBALS[$v]);
        }

        foreach (get_taxonomies([], 'objects') as $t) {
            if ($t->publicly_queryable && !empty($t->query_var)) {
                $GLOBALS['wp']->add_query_var($t->query_var);
            }
        }

        foreach (get_post_types([], 'objects') as $t) {
            if (is_post_type_viewable($t) && !empty($t->query_var)) {
                $GLOBALS['wp']->add_query_var($t->query_var);
            }
        }
    }

    public static function restoreCurrentBlog()
    {
        if (is_multisite()) {
            while (ms_is_switched()) {
                restore_current_blog();
            }
        }
    }
}
