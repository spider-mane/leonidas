<?php

use Respect\Validation\Validator;
use WebTheory\GuctilityBelt\SelectOptions\UsStatesAndTerritories;
use WebTheory\Leonidas\Field;
use WebTheory\Leonidas\Forms\Controllers\TermFieldFormSubmissionManager;
use WebTheory\Leonidas\Leonidas;
use WebTheory\Leonidas\Term\Field as TermField;

################################################################################

$app = require 'config/app.php';
$dataManagers = $app['data_managers'];

$taxonomy = 'wts_test_tax';

$factory = Leonidas::get('container')->get('field');

$state = Field::select([
    'request_var' => 'test-1',
    'type' => [
        'options' => UsStatesAndTerritories::states(),
        'label' => 'Test Label',
        'classlist' => ['regular-text'],
    ],
    'data' => [
        '@create' => 'term_meta',
        'meta_key' => 'test_data',
    ]
]);

$domain = Field::create([
    'request_var' => 'test-2',
    'type' => [
        '@create' => 'text',
        'label' => 'Test 2',
        'classlist' => ['regular-text'],
    ],
    'data' => [
        '@create' => 'term_meta',
        'meta_key' => 'test_data_2'
    ],
    'rules' => [
        'thing' => [
            'validator' => Validator::optional(Validator::domain()),
            'alert' => 'Invalid Domain'
        ]
    ]
]);


$formManager = (new TermFieldFormSubmissionManager($taxonomy))
    ->setFields($state, $domain)
    ->hook();

$address = (new TermField($taxonomy, $state))
    ->setLabel('Test Field')
    ->setDescription('This is a test term field description')
    ->hook();

$domain = (new TermField($taxonomy, $domain))
    ->setLabel('Domain')
    ->setDescription('Enter domain of thing')
    ->hook();
