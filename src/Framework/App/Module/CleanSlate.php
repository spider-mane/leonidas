<?php

namespace Leonidas\Framework\App\Module;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsInitHook;
use Leonidas\Hooks\TargetsWpDashboardSetupHook;
use WP_Post;
use WP_Post_Type;

class CleanSlate extends Module
{
    use TargetsInitHook;
    use TargetsWpDashboardSetupHook;

    public const CONFIG_ROOT = 'modules.clean_slate';

    public function hook(): void
    {
        $this->targetInitHook();
        $this->targetWpDashboardSetupHook();
    }

    protected function doWpDashboardSetupAction(): void
    {
        if (true === $this->getConfig(static::CONFIG_ROOT . '.dashboard.clear')) {
            $this->clearDashboard();
        }
    }

    protected function clearDashboard()
    {
        // use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
        // $network = $network === false ? '' : '-network';

        remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
        remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
        remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
        remove_meta_box('dashboard_activity', 'dashboard', 'normal');   // Activity
    }

    protected function doInitAction()
    {
        if ($unregister = $this->getConfig(static::CONFIG_ROOT . '.post_type.unregister')) {
            $this->unregisterBuiltInPostType((array) $unregister);
        }

        if ($blog = $this->getConfig(static::CONFIG_ROOT . '.blog')) {
            $this->setPostsAsBlog((array) $blog);
        }
    }

    /**
     * sets default post type "post" _builtin value to false so that it can be unregistered
     */
    protected function unregisterBuiltInPostType(array $unregister)
    {
        global $wp_post_types;

        foreach ($unregister as $postType) {
            $wp_post_types[$postType]->_builtin = false;

            unregister_post_type($postType);
        }
    }

    /**
     * Change ui attributes of the "Post" post type to establish it as the blog feature of
     * site rather than primary purpose as suggested by defaults
     */
    protected function setPostsAsBlog(array $args)
    {
        /** @var WP_Post_Type[] $wp_post_types */
        global $wp_post_types;

        $post = $wp_post_types['post'];

        $post->label = $args['label'] ?? "Blog";

        // convert "post" in all labels to "blog post"
        $labels = $post->labels;

        foreach ((array) $labels as $label => $value) {
            $upper = "/Post/";
            $lower = "/post/";

            if (preg_match($upper, $value)) {
                $labels->$label = preg_replace($upper, "Blog Post", $value);
            } elseif (preg_match($lower, $value)) {
                $labels->$label = preg_replace($lower, "blog post", $value);
            }
        }

        // $labels->name = "Blog";
        $labels->menu_name = $args['labels']['menu_name'] ?? "Blog";

        $post->description = $args['description'] ?? 'Site blog';
        $post->menu_position = $args['position'] ?? 9;
        $post->menu_icon = $args['menu_icon'] ?? 'dashicons-welcome-write-blog';

        $supports = [
            'trackbacks',
            'custom-fields',
            'comments',
        ];

        foreach ($supports as $support) {
            remove_post_type_support('post', $support);
        }
    }
}
