<?php

use Backalley\Html\Html;
use Backalley\Form\Fields\Checklist;
use Backalley\Wordpress\Load\Screen;
use Backalley\WordPress\MetaBox\Field;
use Backalley\WordPress\MetaBox\MetaBox;
use Backalley\Form\Controllers\FormFieldController;
use Backalley\WordPress\Fields\Managers\TermRelatedPostsManager;
use Backalley\Wordpress\Forms\Controllers\PostMetaBoxFormSubmissionManager;

#ErrorHandling
// (new Run)->prependHandler(new PrettyPageHandler)->register(); // error handling with whoops

Screen::load('post', ['post_type' => 'ba_location'], function () {
    include 'fields.php';
});

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
