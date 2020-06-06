<?php

use Respect\Validation\Validator;
use WebTheory\Leonidas\Auth\Nonce;
use WebTheory\Leonidas\Fields\Managers\PostMetaFieldManager;
use WebTheory\Leonidas\Fields\WpAdminField;
use WebTheory\Leonidas\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use WebTheory\Leonidas\Helpers\SkyHooks;
use WebTheory\Leonidas\MetaBox\Fieldset;
use WebTheory\Leonidas\MetaBox\MetaBox;
use WebTheory\Saveyour\Fields\Email;
use WebTheory\Saveyour\Fields\Input;
use WebTheory\Saveyour\Fields\Tel;

########################################################################################################################

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
$phone = (new WpAdminField('wts-phone', $field, $phoneData));
$phone->addRule('phone', Validator::optional(Validator::phone()), 'Enter Valid Phone Number');

// fax
$field = (new Input)
    ->setPlaceholder('Fax')
    ->setId('wts-fax');
$data = (new PostMetaFieldManager('wts-fax'));
$fax = (new WpAdminField('wts-fax', $field, $data));
$fax->addRule('fax', Validator::optional(Validator::phone()), 'Enter Valid Fax Number');

// email
$field = (new Input)
    ->setPlaceholder('Email')
    ->setId('wts-email');
$data = (new PostMetaFieldManager('wts-email'));
$email = new WpAdminField('wts-email', $field, $data);
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
$metabox = (new MetaBox('test', 'Test', $postType))
    ->setNonce($nonce)
    ->addContent('contact_info', $contactInfo)
    ->hook();

################################################################################
#
################################################################################
