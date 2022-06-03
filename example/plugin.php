<?php

/**
 * Plugin Name: Test Plugin
 * Version: 1.0.0
 * Text Domain: test-plugin
 * Description: Tests Leonidas functionality in the browser.
 */

use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Access\Authors;
use Leonidas\Library\System\Access\Categories;
use Leonidas\Library\System\Access\Comments;
use Leonidas\Library\System\Access\Images;
use Leonidas\Library\System\Access\Pages;
use Leonidas\Library\System\Access\Posts;
use Leonidas\Library\System\Access\Tags;
use Leonidas\Library\System\Access\Users;

return;

add_action('wp_loaded', function () {
    /** @var PostInterface $post */

    if (is_admin()) {
        return;
    }

    dd(
        'post',
        Posts::select(1)->getName(),
        Posts::select(1)->getComments()->first()->getPost()->getName(),
        Posts::selectName('hello-world'),
        Posts::whereIds(1)->toArray(),
        Posts::select(90),
        Posts::whereIds(90)->toArray(),
        'page',
        Pages::select(2),
        Pages::whereIds(2)->toArray(),
        Pages::select(90),
        Pages::whereIds(90)->toArray(),
        'image',
        Images::select(55),
        Images::whereIds(55)->toArray(),
        Images::select(90),
        Images::whereIds(90)->toArray(),
        'category',
        Categories::select(1),
        Categories::whereIds(1)->toArray(),
        Categories::select(90),
        Categories::whereIds(90)->toArray(),
        'tag',
        Tags::select(2),
        Tags::whereIds(2)->toArray(),
        Tags::select(90),
        Tags::whereIds(90)->toArray(),
        'user',
        Users::select(1),
        Users::whereIds(1)->toArray(),
        Users::select(90),
        Users::whereIds(90)->toArray(),
        'author',
        Authors::select(1),
        Authors::whereIds(1)->toArray(),
        Authors::select(90),
        Authors::whereIds(90)->toArray(),
        'comment',
        Comments::select(1),
        Comments::whereIds(1)->toArray(),
        Comments::select(90),
        Comments::whereIds(90)->toArray(),
    );
});
