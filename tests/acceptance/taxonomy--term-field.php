<?php

use Respect\Validation\Validator;
use WebTheory\GuctilityBelt\SelectOptions\UsStatesAndTerritories;
use WebTheory\Leonidas\Auth\Nonce;
use WebTheory\Leonidas\Forms\Controllers\TermFieldFormSubmissionManager;
use WebTheory\Leonidas\Leonidas;
use WebTheory\Leonidas\Term\Field as TermField;
use WebTheory\Leonidas\Term\FieldLoader;

################################################################################

$app = require 'config/app.php';
$dataManagers = $app['data_managers'];
$taxonomy = 'wts_test_tax';
$factory = Leonidas::get('container')->get('field');
$nonce = new Nonce('wts-nonce--term', 'save-wts-term-fields');

$state = $factory->select([
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

$domain = $factory->create([
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
    ->setNonce($nonce)
    ->hook();

$address = (new TermField($state))
    ->setLabel('State')
    ->setDescription('This is a test term field description');

$domain = (new TermField($domain))
    ->setLabel('Domain')
    ->setDescription('Enter domain of thing');


$loader = new FieldLoader($taxonomy, $address, $domain);
$loader->setNonce($nonce)->hook();
