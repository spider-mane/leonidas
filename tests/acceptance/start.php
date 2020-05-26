<?php

use WebTheory\Leonidas\Helpers\SkyHooks;
use WebTheory\Leonidas\Modules\AdminNotice;
use WebTheory\Leonidas\Screen;
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
    require 'metabox--fieldset.php';
});

// SkyHooks::collect();
// SkyHooks::dump();
