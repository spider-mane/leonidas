<?php

use Leonidas\Library\Admin\Loaders\Screen;
use Leonidas\Library\Core\Helpers\SkyHooks;
use Leonidas\Library\Core\Models\Term\TermCollection;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

#ErrorHandling
// (new Run)->prependHandler(new PrettyPageHandler)->register(); // error handling with whoops

// add_action('parse_request', function ($request) {
//     exit(var_dump($request->query_vars, $request));
// }, null, PHP_INT_MAX);

add_action('init', function () {
    require 'wp-object-factories.php';
    require 'page--standard.php';

    // $terms = TermCollection::fromIds(2, 3, 4, 5);

    // exit(var_dump($terms->getNames()));
});

/**
 * term tests
 */
Screen::load(['edit-tags', 'term'], ['taxonomy' => 'wts_test_tax'], function () {
    require 'taxonomy--term-field.php';
}, 'add-tag');

/**
 * post_type_tests
 */
Screen::load('post', ['post_type' => 'wts_test_cpt'], function () {
    require 'metabox--section.php';
    require 'metabox--fieldset.php';
});

Screen::load('post', ['post_type' => 'wts_test_cpt_2'], function () {
    require 'metabox--field-grid.php';
});

require 'metabox--post-selections.php';

// SkyHooks::collect();
// SkyHooks::dump();
