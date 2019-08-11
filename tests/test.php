<?php

/**
 * alias namespaced classes
 */

use Backalley\Library;
use Backalley\Deblogger;
use Backalley\CustomBlog;
use Backalley\WpAdminBuilder;
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

/**
 * init backalley
 */
Backalley::init([
    'api_keys' => [
        'google_maps' => 'AIzaSyC-PMj5P8atDt61zPmdlCeTkVv4KaW-CiU'
    ]
]);

Library::init();


/**
 * admin modifiers
 */
CustomBlog::from_posts('blog of this here');
Deblogger::clear_dashboard();


/**
 * add admin pages
 */
$admin_pages = AdminPage::create($admin_pages);


/**
 * register post types
 */
$post_types = WpAdminBuilder::post_types();


/**
 * register taxonomies
 */
$taxonomies = WpAdminBuilder::taxonomies();


/**
 * add meta boxes
 */
// $meta_boxes = Backalley_Meta_Box::create($meta_boxes);

/**
 *
 */
$postType = 'ba_location';

$formController = new PostMetaBoxFormSubmissionManager($postType);
$formGroup = new FormSubmissionGroup;

$manager = new PostMetaFieldManager('ba_location_address__state'); #model
$field = (new Select) #view
    ->setId('ba--test--1')
    ->setName('state')
    ->setOptions(UsStatesAndTerritories::states())
    ->addClass('regular-text')
    ->setDisabled(false);
$controller = (new FormFieldController('thing', $field, $manager)); #controller

$select = (new Field('thing', $controller))->setLabel('Select');

$formGroup->addField($controller)
    ->addCallBack('test_joint', function ($arg) {
        exit(var_dump($arg));
    });

$formController->addField($controller)->addGroup('test_group', $formGroup);

$items = [
    'cat' => [
        'value' => 'cat',
        'label' => 'Cat',
        'name' => 'cat',
        'id' => 'test--cat',
    ],
    'dog' => [
        'value' => 'dog',
        'label' => 'Dog',
        'name' => 'dog',
        'id' => 'test--dog',
    ],
];

$manager = new PostMetaFieldManager('ba_location_checklist_test');
$field = (new Checklist)
    ->setId('ba--test--2')
    ->setName('test_thing_2')
    ->setItems($items)
    ->setToggleControl('0');
// ->setClearControl();
$controller = (new FormFieldController('thing2', $field, $manager));
$checklist = (new Field('thing2', $controller))->setLabel('Checklist');
$formController->addField($controller);


$metabox = (new MetaBox('location_test', 'Test'))
    ->setScreen($postType)
    ->setContext('normal')
    ->addContent('thing', $select)
    ->addContent('thing-2', $checklist)
    ->hook();

$formController->hook();


########################################################################################################################

// /**
//  *
//  */
// $postType = 'ba_menu_item';

// $fields = [
//     'test2' => [
//         'description' => 'This is the second test description',
//         'field' => (new Input)
//             ->setId('ba--test-2')
//             ->setName('ba_test2')
//             ->setType('text')
//             ->setLabel('Test 2')
//             ->addClass('small-text'),
//         'manager' => new PostMetaFieldManager('ba_menu_item_price'),
//     ],
//     'test3' => [
//         'description' => 'This is the third test description',
//         'field' => (new Textarea)
//             ->setId('ba--test-3')
//             ->setLabel('Test 3')
//             ->setName('ba_test3')
//             ->addClass('large-text')
//             ->setRows(5),
//         'manager' => new PostMetaFieldManager('ba_menu_item_description')
//     ]
// ];

// $section = new Section('Section Test');
// $formController = new PostMetaBoxFormSubmissionManager($postType);

// foreach ($fields as $slug => $data) {
//     $controller = (new FormFieldController($slug, $data['field'], $data['manager']));

//     $field = (new Field($slug, $controller))
//         ->setLabel($data['field']->getLabel())
//         ->setDescription($data['description']);

//     $section->addContent($slug, $field);

//     $formController->addField($controller);
// }

// $metabox = (new MetaBox('test', 'Test'))
//     ->setScreen('ba_menu_item')
//     ->setContext('normal')
//     ->addContent('test_section', $section)
//     ->hook();


// $formController
//     // ->setPostType($postType)
//     // ->addCallBack('test_callback', function () { })
//     ->addCallBack('test_callback', function ($var) {
//         var_dump($var);
//         // exit;
//     })
//     ->hook();
