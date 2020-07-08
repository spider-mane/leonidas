<?php

use Respect\Validation\Validator;
use WebTheory\Leonidas\Auth\Nonce;
use WebTheory\Leonidas\Constrainers\PostConstrainer;
use WebTheory\Leonidas\Fields\Managers\PostMetaFieldManager;
use WebTheory\Leonidas\Fields\WpAdminField;
use WebTheory\Leonidas\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use WebTheory\Leonidas\Helpers\SkyHooks;
use WebTheory\Leonidas\MetaBox\Field;
use WebTheory\Leonidas\MetaBox\Fieldset;
use WebTheory\Leonidas\MetaBox\MetaBox;
use WebTheory\Leonidas\MetaBox\Section;
use WebTheory\Saveyour\Fields\Email;
use WebTheory\Saveyour\Fields\Input;
use WebTheory\Saveyour\Fields\Tel;

################################################################################
# Base
################################################################################
$postType = 'wts_test_cpt';

################################################################################
# Fields
################################################################################

// phone
$field = (new Input)
    ->setPlaceholder('Phone')
    ->setId('wts-phone');
$phoneData = (new PostMetaFieldManager('wts-phone'));
$phone = (new WpAdminField('wts-phone', $field, $phoneData));
$phone->addRule('phone', Validator::optional(Validator::phone()), 'Enter Valid Phone Number');
$phoneField = (new Field($phone))
    ->setLabel('phone');

// fax
$field = (new Input)
    ->setPlaceholder('Fax')
    ->setId('wts-fax');
$data = (new PostMetaFieldManager('wts-fax'));
$fax = (new WpAdminField('wts-fax', $field, $data));
$fax->addRule('fax', Validator::optional(Validator::phone()), 'Enter Valid Fax Number');
$faxField = (new Field($fax))
    ->setLabel('fax')
    ->setConstraints(new PostConstrainer(4));

// email
$field = (new Input)
    ->setPlaceholder('Email')
    ->setId('wts-email');
$data = (new PostMetaFieldManager('wts-email'));
$email = new WpAdminField('wts-email', $field, $data);
$email->addRule('email', Validator::optional(Validator::email()), 'Enter Valid Email');
$emailField = (new Field($email))
    ->setLabel('email');


################################################################################
# Form
################################################################################
$nonce = new Nonce('wts-metabox', 'save-post-fields');

# submission manager
$formController = (new PostMetaBoxFormSubmissionManager($postType))
    ->setFields($phone, $fax, $email)
    ->setNonce($nonce)
    ->hook();

# section
$contactInfo = (new Section('Contact Information'))
    ->addContent('phone', $phoneField)
    ->addContent('fax', $faxField)
    ->addContent('email', $emailField);

# metabox
$metabox = (new MetaBox('section-test', 'Section Test', $postType))
    ->setNonce($nonce)
    ->addContent('contact_info', $contactInfo)
    ->hook();

################################################################################
#
################################################################################
