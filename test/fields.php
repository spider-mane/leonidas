<?php

use WebTheory\Saveyour\Fields\Email;
use WebTheory\Saveyour\Fields\Tel;
use WebTheory\WordPress\Fields\Managers\PostMetaFieldManager;
use WebTheory\WordPress\MetaBox\Fieldset;
use WebTheory\WordPress\MetaBox\MetaBox;
use WebTheory\WordPress\Fields\WpAdminField;
use WebTheory\WordPress\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use Respect\Validation\Validator as v;


########################################################################################################################

// add_action('parse_request', function ($request) {
//     exit(var_dump($request->query_vars, $request->request, $request));
// }, null, PHP_INT_MAX);


/**
 *
 */
$postType = 'ba_location';
$formController = new PostMetaBoxFormSubmissionManager($postType);



$contactInfo = [
    'phone' => [
        'label' => 'Phone',
        'type' => (new Tel)
            ->setName('contact_info__phone')
            ->setId('ba-location--contact_info--phone')
            ->addClass('regular-text'),
        'data' => (new PostMetaFieldManager('ba_location_contact_info__phone'))
    ],
    'fax' => [
        'label' => 'Fax',
        'type' => (new Tel)
            ->setId('ba-location--contact_info--fax')
            ->addClass('regular-text')
            ->setName('contact_info__fax'),
        'data' => (new PostMetaFieldManager('ba_location_contact_info__fax')),
    ],
    'email' => [
        'label' => 'Email',
        'type' => (new Email)
            ->setName('contact_info__email')
            ->setId('ba-location--contact_info--email')
            ->addClass('regular-text'),
        'data' => (new PostMetaFieldManager('ba_location_contact_info__email')),
    ],
];

foreach ($contactInfo as $slug => &$unit) {
    $unit['field'] = (new WpAdminField("ba_{$slug}", $unit['type'], $unit['data']));
    unset($unit['type'], $unit['data']);
}


$contactInfo = (new Fieldset('Contact Information', $formController))->addFields($contactInfo);


// create metabox
$metabox = (new MetaBox('test', 'Test'))
    ->setScreen($postType)
    ->setContext('normal')
    // ->addContent('address', $address)
    ->addContent('contact_info', $contactInfo)
    ->hook();


$nonce = $metabox->getNonce();
$formController
    ->setNonce($nonce['name'], $nonce['action'])
    // ->addGroup('address', $addressGeoGroup)
    ->hook();

include 'field-grid.php';

$posts = get_posts([
    'post_type' => 'ba_menu_item',
    'posts_per_page' => -1,
    'orderby' => 'name',
    'order' => 'ASC',
]);


foreach ($posts as $post) {
    $items[$post->post_name] = [
        'value' => '1',
        'label' => $post->post_title,
        'name' => (string) $post->ID,
        'id' => "ba--location-menu-item--{$post->post_name}",
    ];
}
