<?php

use Backalley\GuctilityBelt;
use Backalley\Form\Fields\Input;
use Backalley\Form\Fields\Select;
use Backalley\WordPress\AdminPage;
use Backalley\WordPress\Backalley;
use Backalley\Form\Fields\Textarea;
use Backalley\Form\Fields\Checklist;
use Backalley\WordPress\MetaBox\Field;
use Backalley\WordPress\MetaBox\MetaBox;
use Backalley\WordPress\MetaBox\Section;
use Backalley\Form\Controllers\FormFieldController;
use Backalley\Support\SelectOptions\UsStatesAndTerritories;
use Backalley\WordPress\Fields\Managers\PostMetaFieldManager;
use Backalley\Wordpress\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use Backalley\Form\Controllers\FormSubmissionGroup;

use function Backalley\GuctilityBelt\address_format;
use function Backalley\GuctilityBelt\google_geocode;
use Backalley\WordPress\MetaBox\Fieldset;
use Respect\Validation\Validator as v;

/**
 * add meta boxes
 */

// /**
//  *
//  */
// $postType = 'ba_location';

// $formController = new PostMetaBoxFormSubmissionManager($postType);
// $formGroup = new FormSubmissionGroup;

// $manager = new PostMetaFieldManager('ba_location_address__state'); #model
// $field = (new Select) #view
//     ->setId('ba--test--1')
//     ->setName('state')
//     ->setOptions(UsStatesAndTerritories::states())
//     ->addClass('regular-text')
//     ->setDisabled(false);
// $controller = (new FormFieldController('thing', $field, $manager)); #controller

// $select = (new Field('thing', $controller))->setLabel('Select');

// $formGroup->addField($controller)
//     ->addCallBack('test_joint', function ($arg) {
//         // exit(var_dump($arg));
//     });

// $formController->addField($controller)->addGroup('test_group', $formGroup);

// $items = [
//     'cat' => [
//         'value' => 'cat',
//         'label' => 'Cat',
//         'name' => 'cat',
//         'id' => 'test--cat',
//     ],
//     'dog' => [
//         'value' => 'dog',
//         'label' => 'Dog',
//         'name' => 'dog',
//         'id' => 'test--dog',
//     ],
// ];

// $manager = new PostMetaFieldManager('ba_location_checklist_test');
// $field = (new Checklist)
//     ->setId('ba--test--2')
//     ->setName('test_thing_2')
//     ->setItems($items)
//     ->setToggleControl('0');
// // ->setClearControl();
// $controller = (new FormFieldController('thing2', $field, $manager));
// $checklist = (new Field('thing2', $controller))->setLabel('Checklist');
// $formController->addField($controller);


// $metabox = (new MetaBox('location_test', 'Test'))
//     ->setScreen($postType)
//     ->setContext('normal')
//     ->addContent('thing', $select)
//     ->addContent('thing-2', $checklist)
//     ->hook();

// $formController->hook();


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
            ->setName('street')
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
            ->setName('city')
            ->addClass('regular-text'),
        'data' => new PostMetaFieldManager('ba_location_address__city'),
        'groups' => 'address'
    ],
    'state' => [
        'label' => 'State',
        'type' => (new Select)
            ->setId('ba-location--address--state')
            ->setName('state')
            ->addClass('regular-text')
            ->setOptions(UsStatesAndTerritories::states('Select State')),
        'data' => new PostMetaFieldManager('ba_location_address__state'),
        'groups' => 'address'
    ],
    'zip' => [
        'label' => 'Zip',
        'type' => (new Input)
            ->setName('zip')
            ->setId('ba-location--address--zip')
            ->addClass('small-text')
            ->setPlaceholder('Zip'),
        'data' => new PostMetaFieldManager('ba_location_address__zip'),
        'groups' => 'address'
    ],
    'complete' => [
        'label' => 'Complete',
        'type' => (new Input)
            ->setName('address')
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
$addressGeoGroup = (new FormSubmissionGroup);

/** @var FormFieldController $controller */
foreach ([$controllers['complete'], $controllers['geo']] as $controller) {
    $controller->setSavingDisabled(true);
}

$fields = [
    'street' => $controllers['street'],
    'city' => $controllers['city'],
    'state' => $controllers['state'],
    'zip' => $controllers['zip'],
];

foreach ($fields as $slug => $field) {
    $addressGeoGroup->addField($field);
}

// add callback to group
$addressGeoGroup->addCallBack('geodata', function ($results, $post) {

    $updated = false;
    $post_id = $post->ID;

    foreach ($results as $result) {
        if (true === $result['saved']) {
            $updated = true;
            break;
        }
    }

    if (true === $updated) {
        $complete = GuctilityBelt::concat_address(
            $results['ba_street']['value'],
            $results['ba_city']['value'],
            $results['ba_state']['value'],
            $results['ba_zip']['value']
        );

        update_post_meta($post_id, "ba_location_address__complete", $complete);

        if (isset(Backalley::$api_keys['google_maps'])) {

            $coordinates = GuctilityBelt::google_geocode($complete, Backalley::$api_keys['google_maps']);

            update_post_meta($post_id, "ba_location_address__geo", $coordinates);
        }
    }
});


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
            // ->setType('email')
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
