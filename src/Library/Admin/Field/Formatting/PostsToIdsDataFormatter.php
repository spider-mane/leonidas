<?php

namespace Leonidas\Library\Admin\Field\Formatting;

use Leonidas\Library\System\Schema\Post\PostCollection;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;
use WP_Post;

class PostsToIdsDataFormatter implements DataFormatterInterface
{
    /**
     * @param array<WP_Post> $posts
     */
    public function formatData($posts): array
    {
        $posts = new PostCollection(...$posts);

        return array_map('strval', $posts->getIds());
    }

    public function formatInput($posts): array
    {
        if (in_array('', $posts)) {
            unset($posts[array_search('', $posts)]);
        }

        return array_map('intval', $posts);
    }
}
