<?php

namespace Leonidas\Library\System\Schema\Abstracts;

use WP_Comment_Query;
use WP_Post;
use WP_Query;
use WP_Term_Query;
use WP_User_Query;

abstract class AbstractEntityManager
{
    protected function getPosts(array $query): array
    {
        return (new WP_Query())->query($query);
    }

    protected function getPost(array $query): ?WP_Post
    {
        return ($posts = $this->getPosts($query)) ? reset($posts) : null;
    }

    protected function getPostField(int $id, string $field): string
    {
        return get_post_field($field, $id, 'raw');
    }

    protected function getPostMeta(int $id, string $field): string
    {
        return get_post_meta($id, $field, true);
    }

    protected function getPostMetaArray(int $id, string $field): array
    {
        return get_post_meta($id, $field, false);
    }

    protected function getTerms(array $query): array
    {
        return (new WP_Term_Query())->query($query);
    }

    protected function getTermField(string $field, int $id, string $taxonomy = ''): string
    {
        return get_term_field($field, $id, $taxonomy, 'raw');
    }

    protected function getComments(array $query): array
    {
        return (new WP_Comment_Query())->query($query);
    }

    protected function getUsers(array $query): array
    {
        return (new WP_User_Query($query))->get_results();
    }
}
