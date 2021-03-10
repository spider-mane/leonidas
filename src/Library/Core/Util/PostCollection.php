<?php

namespace WebTheory\Leonidas\Library\Core\Util;

use WP_Post;
use WP_Query;

class PostCollection
{
    /**
     * @var WP_Post[]
     */
    protected $posts;

    /**
     * @param WP_Post $posts
     */
    public function __construct(WP_Post ...$posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get the value of posts
     *
     * @return WP_Post[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    /**
     *
     */
    public function get(string $property)
    {
        return array_map(function (WP_Post $post) use ($property) {
            return $post->{$property};
        }, $this->posts);
    }

    /**
     *
     */
    public function getIds()
    {
        return $this->get('ID');
    }

    /**
     *
     */
    public function getNames()
    {
        return $this->get('post_name');
    }

    /**
     *
     */
    public function getTitles()
    {
        return $this->get('post_title');
    }

    /**
     *
     */
    public function getPostTypes()
    {
        return $this->get('post_type');
    }

    /**
     *
     */
    public function isEmpty(): bool
    {
        return empty($this->posts);
    }

    /**
     *
     */
    public function append(WP_Post $post)
    {
        $this->posts[] = $post;
    }

    /**
     *
     */
    protected function diffCallback()
    {
        return function (WP_Post $post1, WP_Post $post2) {
            return $post1->ID - $post2->ID;
        };
    }

    /**
     *
     */
    public function without(PostCollection $collection)
    {
        return array_udiff(
            $this->getPosts(),
            $collection->getPosts(),
            $this->diffCallback()
        );
    }

    /**
     *
     */
    public function notIn(PostCollection $collection)
    {
        return array_udiff(
            $collection->getPosts(),
            $this->getPosts(),
            $this->diffCallback()
        );
    }

    /**
     *
     */
    public function diff(PostCollection $collection): array
    {
        $primary = $this->getPosts();
        $secondary = $collection->getPosts();
        $cb = $this->diffCallback();

        /*
         * if both primary and secondary are empty this will return false
         * because the "array_diff" family of functions returns an empty array
         * if the first array provided is empty itself. if both arrays are
         * empty this will return an empty array as there is no difference.
         */
        return !empty($primary)
            ? array_udiff($primary, $secondary, $cb)
            : array_udiff($secondary, $primary, $cb);
    }

    /**
     *
     */
    public function isDiff(PostCollection $collection): bool
    {
        return (bool) $this->diff($collection);
    }

    /**
     *
     */
    public static function fromQuery(WP_Query $query): PostCollection
    {
        $query->set('fields', 'all');

        return new static(...$query->get_posts());
    }

    /**
     *
     */
    public static function create(array $args): PostCollection
    {
        return static::fromQuery(new WP_Query($args));
    }

    /**
     *
     */
    public static function fromIds(int ...$ids): PostCollection
    {
        return static::create([
            'post_type' => 'any',
            'post__in' => $ids,
            'posts_per_page' => -1
        ]);
    }
}
