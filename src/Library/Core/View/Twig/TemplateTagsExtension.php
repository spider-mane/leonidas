<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class TemplateTagsExtension extends AbstractExtension implements ExtensionInterface
{
    public const GENERAL = [
        'get_header',
        'get_footer',
        'get_sidebar',
        'get_template_part',
        'get_search_form',
        'wp_loginout',
        'wp_logout_url',
        'wp_login_url',
        'wp_login_form',
        'wp_lostpassword_url',
        'wp_register',
        'wp_meta',
        'bloginfo',
        'get_bloginfo',
        'get_current_blog_id',
        'wp_title',
        'single_post_title',
        'post_type_archive_title',
        'single_cat_title',
        'single_tag_title',
        'single_term_title',
        'single_month_title',
        'get_archives_link',
        'wp_get_archives',
        'calendar_week_mod',
        'get_calendar',
        'delete_get_calendar_cache',
        'allowed_tags',
        'wp_enqueue_script',
    ];

    public const AUTHOR = [
        'the_author',
        'get_the_author',
        'the_author_link',
        'get_the_author_link',
        'the_author_meta',
        'the_author_posts',
        'the_author_posts_link',
        'wp_dropdown_users',
        'wp_list_authors',
        'get_author_posts_url',
    ];

    public const BOOKMARK = [
        'wp_list_bookmarks',
        'get_bookmark',
        'get_bookmark_field',
        'get_bookmarks',
    ];

    public const CATEGORY = [
        'category_description',
        'single_cat_title',
        'the_category',
        'the_category_rss',
        'wp_dropdown_categories',
        'wp_list_categories',
        'single_tag_title',
        'tag_description',
        'the_tags',
        'wp_generate_tag_cloud',
        'wp_tag_cloud',
        'term_description',
        'single_term_title',
        'get_the_term_list',
        'the_terms',
        'the_taxonomies',
    ];

    public const COMMENT = [
        'cancel_comment_reply_link',
        'comment_author',
        'comment_author_email',
        'comment_author_email_link',
        'comment_author_IP',
        'comment_author_link',
        'comment_author_rss',
        'comment_author_url',
        'comment_author_url_link',
        'comment_class',
        'comment_date',
        'comment_excerpt',
        'comment_form_title',
        'comment_form',
        'comment_ID',
        'comment_id_fields',
        'comment_reply_link',
        'comment_text',
        'comment_text_rss',
        'comment_time',
        'comment_type',
        'comments_link',
        'comments_number',
        'comments_popup_link',
        'get_avatar',
        'next_comments_link',
        'paginate_comments_links',
        'permalink_comments_rss',
        'previous_comments_link',
        'wp_list_comments',
    ];

    public const LINK = [
        'the_permalink',
        'user_trailingslashit',
        'permalink_anchor',
        'get_permalink',
        'get_post_permalink',
        'get_page_link',
        'get_attachment_link',
        'wp_shortlink_header',
        'wp_shortlink_wp_head',
        'edit_bookmark_link',
        'edit_comment_link',
        'edit_post_link',
        'get_edit_post_link',
        'get_delete_post_link',
        'edit_tag_link',
        'get_admin_url',
        'get_home_url',
        'get_site_url',
        'home_url',
        'site_url',
        'get_search_link',
        'get_search_query',
        'the_feed_link',
        'the_privacy_policy_link',
        'get_the_privacy_policy_link',
    ];

    public const POST = [
        'body_class',
        'next_image_link',
        'next_post_link',
        'next_posts_link',
        'post_class',
        'post_password_required',
        'posts_nav_link',
        'previous_image_link',
        'previous_post_link',
        'previous_posts_link',
        'single_post_title',
        'the_category',
        'the_category_rss',
        'the_content',
        'the_excerpt',
        'the_excerpt_rss',
        'the_ID',
        'the_meta',
        'the_tags',
        'the_title',
        'get_the_title',
        'the_title_attribute',
        'the_title_rss',
        'wp_link_pages',
        'get_attachment_link',
        'wp_get_attachment_link',
        'the_attachment_link',
        'the_search_query',
        'is_attachment',
        'wp_attachment_is_image',
        'wp_get_attachment_image',
        'wp_get_attachment_image_src',
        'wp_get_attachment_metadata',
        'get_the_date',
        'single_month_title',
        'the_date',
        'the_date_xml',
        'the_modified_author',
        'the_modified_date',
        'the_modified_time',
        'the_time',
        'the_shortlink',
        'wp_get_shortlink',
    ];

    public const POST_THUMBNAIL = [
        'has_post_thumbnail',
        'get_post_thumbnail_id',
        'the_post_thumbnail',
        'get_the_post_thumbnail',
    ];

    public const NAVIGATION_MENU = [
        'wp_nav_menu',
        'walk_nav_menu_tree',
    ];

    public function getFunctions()
    {
        return array_map(fn ($tag) => new TwigFunction($tag, $tag), [
            ...static::GENERAL,
            ...static::AUTHOR,
            ...static::BOOKMARK,
            ...static::CATEGORY,
            ...static::COMMENT,
            ...static::LINK,
            ...static::POST,
            ...static::POST_THUMBNAIL,
            ...static::NAVIGATION_MENU,
        ]);
    }
}
