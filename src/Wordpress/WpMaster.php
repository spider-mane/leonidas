<?php

namespace WebTheory\WordPress;

class WpMaster
{
    /**
     *
     */
    public static function clearDashboard()
    {
        add_action('wp_dashboard_setup', function (bool $network = false) {
            // use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
            $network = $network === false ? '' : '-network';

            remove_meta_box('dashboard_right_now', 'dashboard' . $network, 'normal');   // Right Now
            remove_meta_box('dashboard_recent_comments', 'dashboard' . $network, 'normal'); // Recent Comments
            remove_meta_box('dashboard_incoming_links', 'dashboard' . $network, 'normal');  // Incoming Links
            remove_meta_box('dashboard_plugins', 'dashboard . $network', 'normal');   // Plugins
            remove_meta_box('dashboard_quick_press', 'dashboard' . $network, 'side');  // Quick Press
            remove_meta_box('dashboard_recent_drafts', 'dashboard' . $network, 'side');  // Recent Drafts
            remove_meta_box('dashboard_primary', 'dashboard' . $network, 'side');   // WordPress blog
            remove_meta_box('dashboard_secondary', 'dashboard' . $network, 'side');   // Other WordPress News
            remove_meta_box('dashboard_activity', 'dashboard' . $network, 'normal');   // Activity
        });
    }

    /**
     * sets default post type "post" _builtin value to false so that it can be unregistered
     */
    public static function unregisterBuiltInPostType($post_type = 'post')
    {
        global $wp_post_types;
        $wp_post_types[$post_type]->_builtin = false;

        unregister_post_type($post_type);
    }

    /**
     * Change ui attributes of the "Post" post type to establish it as the blog feature of
     * site rather than primary purpose as suggested by defaults
     */
    public static function setPostsAsBlog($description = 'Site blog', $icon = 'dashicons-welcome-write-blog', $position = 9)
    {
        global $wp_post_types;
        $wp_post = $wp_post_types['post'];

        $wp_post->label = "Blog";

        // convert "post" in all labels to "blog post"
        $labels = $wp_post->labels;

        foreach ($labels as $label => $value) {
            $upper = "/Post/";
            $lower = "/post/";

            if (preg_match($upper, $value)) {
                $labels->$label = preg_replace($upper, "Blog Post", $value);
            } elseif (preg_match($lower, $value)) {
                $labels->$label = preg_replace($lower, "blog post", $value);
            }
        }

        // $labels->name = "Blog";
        $labels->menu_name = "Blog";

        $wp_post->description = $description;
        $wp_post->menu_position = $position;
        $wp_post->menu_icon = $icon;


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
