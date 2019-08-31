<?php

use Backalley\GuctilityBelt;
use Backalley\Form\Fields\Input;
use Backalley\Form\Fields\Select;
use Backalley\WordPress\AdminPage;
use Backalley\WordPress\Backalley;
use Backalley\Form\Fields\Textarea;
use Backalley\Form\Fields\Checklist;
use Backalley\WordPress\MetaBox\Field;
use Respect\Validation\Validator as v;
use Backalley\WordPress\MetaBox\MetaBox;
use Backalley\WordPress\MetaBox\Section;
use Backalley\WordPress\MetaBox\Fieldset;
use Backalley\GuctilityBelt\Address\Address;
use Backalley\Form\Controllers\FormFieldController;
use Backalley\Form\Groups\AddressMetaGroup;
use Backalley\GuctilityBelt\Address\GoogleGeocoder;

use function Backalley\GuctilityBelt\address_format;

use function Backalley\GuctilityBelt\google_geocode;
use Backalley\WordPress\Fields\Managers\PostTermManager;
use Backalley\Wordpress\Fields\Managers\TermBasedPostMeta;
use Backalley\WordPress\Fields\Managers\PostMetaFieldManager;
use Backalley\WordPress\Fields\Managers\TermRelatedPostsManager;
use Backalley\GuctilityBelt\SelectOptions\UsStatesAndTerritories;
use Backalley\Wordpress\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use Backalley\Wordpress\Fields\Transformers\PostRelationshipChecklistTransformer;






########################################################################################################################
// add_action('parse_request', function ($request) {
//     exit(var_dump($request->query_vars, $request->request, $request));
// }, null, PHP_INT_MAX);


// $screen = get_current_screen();
// exit(var_dump($screen));
/**
 *
 */
$postType = 'ba_location';
$formController = new PostMetaBoxFormSubmissionManager($postType);


$address = [
    'street' => [
        'label' => 'Street',
        'type' => (new Input)
            ->setId('ba-location--address--street')
            ->setType('text')
            ->addClass('regular-text'),
        'data' => new PostMetaFieldManager('ba_location_address__street'),
        'groups' => 'address'
    ],
    'city' => [
        'label' => 'City',
        'type' => (new Input)
            ->setId('ba-location--address--city')
            ->setType('text')
            ->addClass('regular-text'),
        'data' => new PostMetaFieldManager('ba_location_address__city'),
        'groups' => 'address'
    ],
    'state' => [
        'label' => 'State',
        'type' => (new Select)
            ->setId('ba-location--address--state')
            ->addClass('regular-text')
            ->setOptions(UsStatesAndTerritories::states('Select State')),
        'data' => new PostMetaFieldManager('ba_location_address__state'),
        'groups' => 'address'
    ],
    'zip' => [
        'label' => 'Zip',
        'type' => (new Input)
            ->setId('ba-location--address--zip')
            ->addClass('small-text')
            ->setPlaceholder('Zip'),
        'data' => new PostMetaFieldManager('ba_location_address__zip'),
        'groups' => 'address'
    ],
    'complete' => [
        'label' => 'Complete',
        'type' => (new Input)
            ->setId('ba-location--address--complete')
            ->addClass('regular-text')
            ->setPlaceholder('Formatted Address')
            ->setDisabled(true),
        'data' => (new PostMetaFieldManager('ba_location_address__complete')),
    ],
    'geo' => [
        'label' => 'Geo Location',
        'type' => (new Input)
            ->setDisabled(true)
            ->setName('geo')
            ->setId('ba-location--address--geo')
            ->addClass('regular-text'),
        'data' => (new PostMetaFieldManager('ba_location_address__geo')),
    ]
];

$address = (new Fieldset('Address', $formController))->setFields($address);

$controllers = $address->getControllers();
/** @var FormFieldController $controller */
foreach ([$controllers['complete'], $controllers['geo']] as $controller) {
    $controller->setSavingDisabled(true);
}

$geo = (new PostMetaFieldManager('ba_location_address__geo'));
$complete = (new PostMetaFieldManager('ba_location_address__complete'));
$addressHelper = (new Address)->setGeocoder(new GoogleGeocoder('AIzaSyC-PMj5P8atDt61zPmdlCeTkVv4KaW-CiU'));
$addressGeoGroup = (new AddressMetaGroup($addressHelper, $complete))->setGeoDataManager($geo);

$fields = [
    'street' => $controllers['street'],
    'city' => $controllers['city'],
    'state' => $controllers['state'],
    'zip' => $controllers['zip'],
];

foreach ($fields as $slug => $field) {
    $addressGeoGroup->setField($slug, $field);
}


$contactInfo = [
    'phone' => [
        'label' => 'Phone',
        'type' => (new Input)
            ->setType('tel')
            ->setName('contact_info__phone')
            ->setId('ba-location--contact_info--phone')
            ->addClass('regular-text'),
        'data' => (new PostMetaFieldManager('ba_location_contact_info__phone'))
    ],
    'fax' => [
        'label' => 'Fax',
        'type' => (new Input)
            ->setType('tel')
            ->setName('contact_info__fax')
            ->setId('ba-location--contact_info--fax')
            ->addClass('regular-text'),
        'data' => (new PostMetaFieldManager('ba_location_contact_info__fax')),
    ],
    'email' => [
        'label' => 'Email',
        'type' => (new Input)
            ->setType('email')
            ->setName('contact_info__email')
            ->setId('ba-location--contact_info--email')
            ->addClass('regular-text'),
        'data' => (new PostMetaFieldManager('ba_location_contact_info__email')),
    ],
];

$contactInfo = (new Fieldset('Contact Information', $formController))->setFields($contactInfo);

$fields = $contactInfo->getControllers();
$fields['phone']
    ->addRule('tel', v::optional(v::phone()))
    ->addAlert('tel', 'Invalid phone number provided');

$fields['fax']
    ->addRule('tel', v::optional(v::phone()))
    ->addAlert('tel', 'Invalid fax number provided');

$fields['email']
    ->addRule('email', v::optional(v::email()))
    ->addAlert('email', 'Invalid email address provided');



// create metabox
$metabox = (new MetaBox('test', 'Test'))
    ->setScreen($postType)
    ->setContext('normal')
    ->addContent('address', $address)
    ->addContent('contact_info', $contactInfo)
    ->hook();


$nonce = $metabox->getNonce();
$formController
    ->setNonce($nonce['name'], $nonce['action'])
    ->addGroup('address', $addressGeoGroup)
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

$manager = new TermRelatedPostsManager('_ba_location_', 'ba_menu_item', $postType);
$field = (new Checklist)
    ->setId('ba-location--menu_items')
    ->setItems($items)
    ->setToggleControl('0');
// ->setClearControl();
$controller = (new FormFieldController('menu_items', $field, $manager));
$checklist = (new Field('thing2', $controller))->setLabel('Menu Items');

$metabox->addContent('menu_items', $checklist);
$formController->addField($controller);


$taxonomy = 'ba_delivery_platforms';
$attribute = 'doordash';
$metaKey = "ba_location_delivery_platforms__{$attribute}";

$manager = new TermBasedPostMeta($metaKey, $taxonomy, $attribute);
$element = (new Input)->addClass('large-text')->setType('text');
$controller = (new FormFieldController('dp_doordash', $element, $manager));
$field = (new Field('doordash', $controller))->setLabel('DoorDash');

$metabox->addContent('delivery_platform', $field);
$formController->addField($controller);
