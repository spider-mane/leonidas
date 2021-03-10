<?php

use Respect\Validation\Validator;
use WebTheory\Leonidas\Library\Admin\Fields\Managers\TermMetaDataManager;
use WebTheory\Leonidas\Library\Admin\Forms\Controllers\TermFieldFormSubmissionManager;
use WebTheory\Leonidas\Library\Admin\Loaders\TermFieldCollectionLoader;
use WebTheory\Leonidas\Library\Admin\Term\Components\TermField;
use WebTheory\Leonidas\Library\Core\Auth\Nonce;
use WebTheory\Saveyour\Controllers\FormFieldControllerBuilder;
use WebTheory\Saveyour\Fields\Select;
use WebTheory\Saveyour\Fields\Text;
use WebTheory\Saveyour\Selections\StateSelectOptions;

################################################################################

$taxonomy = 'wts_test_tax';
$nonce = new Nonce('wts-nonce--term', 'save-wts-term-fields');

$field = (new Select)
    ->setSelectionProvider(new StateSelectOptions())
    ->setLabel('Test Label')
    ->setClasslist(['regular-text']);

$manager = new TermMetaDataManager('test_data');

$state = (new FormFieldControllerBuilder('test-1'))
    ->setFormField($field)
    ->setDataManager($manager)
    ->create();

################################################################################
#
################################################################################

$field = (new Text)
    ->setLabel('Test 2')
    ->setClasslist(['regular-text']);

$manager = new TermMetaDataManager('test_data_2');

$domain = (new FormFieldControllerBuilder('test-2'))
    ->setFormField($field)
    ->setDataManager($manager)
    ->addRule('thing', Validator::optional(Validator::domain(false)), 'Invalid Domain')
    ->create();

################################################################################
#
################################################################################

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


$loader = new TermFieldCollectionLoader($taxonomy, $address, $domain);
$loader->setTokenManager($nonce)->hook();
