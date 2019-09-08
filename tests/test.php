<?php

use Backalley\Form\Controllers\FormFieldController;
use Backalley\Form\FieldFactory;
use Backalley\Form\Fields\Checklist;
use Backalley\Form\Fields\DateTimeLocal;
use Backalley\Form\Fields\Input;
use Backalley\Form\Fields\Range;
use Backalley\Form\Fields\Text;
use Backalley\Form\Fields\Textarea;
use Backalley\GuctilityBelt\SelectOptions\UsStatesAndTerritories;
use Backalley\WordPress\Fields\Managers\TermMetaDataManager;
use Backalley\WordPress\Fields\Managers\TermRelatedPostsManager;
use Backalley\WordPress\Fields\WpAdminField;
use Backalley\WordPress\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use Backalley\WordPress\MetaBox\Field;
use Backalley\WordPress\MetaBox\MetaBox;
use Backalley\WordPress\Taxonomy\Factory as TaxonomyFactory;
use Backalley\WordPress\Term\Field as TermField;
use Backalley\Wordpress\Fields\Managers\Factory;
use Backalley\Wordpress\Forms\Controllers\TermFieldFormSubmissionManager;
use Backalley\Wordpress\Helpers\Screen;
use Backalley\Wordpress\PostType\Factory as PostTypeFactory;

#ErrorHandling
// (new Run)->prependHandler(new PrettyPageHandler)->register(); // error handling with whoops

add_action('init', function () {

    $app = require 'config/app.php';
    $postTypeHandlers = $app['post_type']['option_handlers'];
    $taxonomyHandlers = $app['taxonomy']['option_handlers'];

    $postTypes = require 'config/post_types.php';
    $taxonomies = require 'config/taxonomies.php';

    $postTypes = (new PostTypeFactory($postTypeHandlers))->create($postTypes);
    $taxonomies = (new TaxonomyFactory($taxonomyHandlers))->create($taxonomies);

    require 'admin-page.php';
});

/**
 *
 */
Screen::load(['edit-tags', 'term'], ['taxonomy' => 'ba_menu_category'], function () {

    $taxonomy = 'ba_menu_category';

    $args = [
        'options' => UsStatesAndTerritories::states(),
        'label' => 'Test Label',
        'classlist' => ['regular-text'],
    ];

    $element = FieldFactory::select($args);
    // $element = (new FieldFactory)->create($args);

    $manager = Factory::termMeta(['meta_key' => 'test_data']);
    $controller = (new WpAdminField('thing', $element, $manager));
    $formManager = (new TermFieldFormSubmissionManager($taxonomy));
    $field = (new TermField($taxonomy))
        ->setFormFieldController($controller)
        ->setLabel('Test Field')
        ->setDescription('This is a test term field description')
        ->hook();

    $formManager->addField($controller)->hook();
});

/**
 *
 */
Screen::load('post', ['post_type' => 'ba_location'], function () {
    include 'fields.php';
});

/**
 *
 */
Screen::load('post', ['post_type' => 'ba_menu_item'], function () {

    $postType = 'ba_menu_item';

    $metabox = (new MetaBox('test', 'Test'))
        ->setScreen($postType)
        ->setContext('normal');

    $nonce = $metabox->getNonce();
    $formManager = (new PostMetaBoxFormSubmissionManager($postType))
        ->setNonce($nonce['name'], $nonce['action']);


    $posts = get_posts([
        'post_type' => 'ba_location',
        'posts_per_page' => -1,
        'orderby' => 'name',
        'order' => 'ASC',
    ]);


    foreach ($posts as $post) {
        $items[(string) $post->ID] = [
            'value' => (string) $post->ID,
            'label' => $post->post_title,
            'id' => "ba--location-menu-item--{$post->post_name}",
        ];
    }

    $manager = new TermRelatedPostsManager('_ba_location_', $postType, 'ba_location');
    $field = (new Checklist)
        ->setId('ba-location--menu_items')
        ->setItems($items);
    // ->setClearControl();
    $controller = (new FormFieldController('ba_menu_item__locations', $field, $manager));
    $checklist = (new Field('thing2', $controller))->setLabel('Locations Available');

    $metabox->addContent('locations', $checklist)->hook();

    $formManager->addField($controller)->hook();
});


/**
 *
 */
// SkyHooks::collect();
// SkyHooks::dump();
