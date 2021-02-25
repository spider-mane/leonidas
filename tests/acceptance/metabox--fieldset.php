<?php

use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\ServerRequest;
use Respect\Validation\Validator;
use WebTheory\Leonidas\Admin\Fields\Managers\PostMetaFieldManager;
use WebTheory\Leonidas\Admin\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use WebTheory\Leonidas\Admin\Metabox\Components\Fieldset;
use WebTheory\Leonidas\Admin\Metabox\Metabox;
use WebTheory\Leonidas\Core\Auth\Nonce;
use WebTheory\Leonidas\Core\Helpers\SkyHooks;
use WebTheory\Saveyour\Controllers\FormFieldController;
use WebTheory\Saveyour\Fields\Email;
use WebTheory\Saveyour\Fields\Input;
use WebTheory\Saveyour\Fields\Tel;
use WebTheory\Saveyour\Request;

########################################################################################################################

// exit(var_dump($_REQUEST));

/**
 *
 */
$postType = 'wts_test_cpt';
$nonce = new Nonce('wts-metabox', 'save-post-fields');

/**
 * create fields
 */

// phone
$field = (new Input)
    ->setPlaceholder('Phone')
    ->setId('wts-phone');
$phoneData = (new PostMetaFieldManager('wts-phone'));
$phone = (new FormFieldController('wts-phone', $field, $phoneData));
$phone->addRule('phone', Validator::optional(Validator::phone()), 'Enter Valid Phone Number');

// fax
$field = (new Input)
    ->setPlaceholder('Fax')
    ->setId('wts-fax');
$data = (new PostMetaFieldManager('wts-fax'));
$fax = (new FormFieldController('wts-fax', $field, $data));
$fax->addRule('fax', Validator::optional(Validator::phone()), 'Enter Valid Fax Number');

// email
$field = (new Input)
    ->setPlaceholder('Email')
    ->setId('wts-email');
$data = (new PostMetaFieldManager('wts-email'));
$email = new FormFieldController('wts-email', $field, $data);
$email->addRule('email', Validator::optional(Validator::email()), 'Enter Valid Email');


/**
 *
 */
$formController = (new PostMetaBoxFormSubmissionManager($postType))
    ->setFields($phone, $fax, $email)
    ->setNonce($nonce)
    ->hook();

/**
 * create fieldset
 */
$contactInfo = new Fieldset('Contact Information', $formController);
$contactInfo->addFields([
    'phone' => [
        'field' => $phone,
        'label' => 'Phone',
        'description' => 'Enter phone number',
    ],

    'fax' => [
        'field' => $fax,
        'label' => 'Fax',
        'description' => 'Enter fax number',
    ],

    'email' => [
        'field' => $email,
        'label' => 'Email',
        'description' => 'Enter email address',
    ],
]);


//
$metabox = (new Metabox('fieldset-test', 'Fieldset Test', $postType))
    ->setNonce($nonce)
    ->addContent('contact_info', $contactInfo)
    ->hook();

################################################################################
#
################################################################################
