<?php

use Respect\Validation\Validator;
use Leonidas\Library\Admin\Constrainers\PostConstrainer;
use Leonidas\Library\Admin\Fields\Managers\PostMetaFieldManager;
use Leonidas\Library\Admin\Fields\WpAdminField;
use Leonidas\Library\Admin\Forms\Controllers\PostMetaboxFormSubmissionManager;
use Leonidas\Library\Admin\Metabox\Components\Field;
use Leonidas\Library\Admin\Metabox\Components\Fieldset;
use Leonidas\Library\Admin\Metabox\Components\Section;
use Leonidas\Library\Admin\Metabox\AutoLoadingMetabox;
use Leonidas\Library\Core\Auth\Nonce;
use Leonidas\Library\Core\Helpers\SkyHooks;
use WebTheory\Saveyour\Controllers\FormFieldController;
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
$phone = (new FormFieldController('wts-phone', $field, $phoneData));
$phone->addRule('phone', Validator::optional(Validator::phone()), 'Enter Valid Phone Number');
$phoneField = (new Field($phone))
    ->setLabel('phone');

// fax
$field = (new Input)
    ->setPlaceholder('Fax')
    ->setId('wts-fax');
$data = (new PostMetaFieldManager('wts-fax'));
$fax = (new FormFieldController('wts-fax', $field, $data));
$fax->addRule('fax', Validator::optional(Validator::phone()), 'Enter Valid Fax Number');
$faxField = (new Field($fax))
    ->setLabel('fax')
    ->setConstraints(new PostConstrainer(4));

// email
$field = (new Input)
    ->setPlaceholder('Email')
    ->setId('wts-email');
$data = (new PostMetaFieldManager('wts-email'));
$email = new FormFieldController('wts-email', $field, $data);
$email->addRule('email', Validator::optional(Validator::email()), 'Enter Valid Email');
$emailField = (new Field($email))
    ->setLabel('email');


################################################################################
# Form
################################################################################
$nonce = new Nonce('wts-metabox', 'save-post-fields');

# submission manager
$formController = (new PostMetaboxFormSubmissionManager($postType))
    ->setFields($phone, $fax, $email)
    ->setNonce($nonce)
    ->hook();

# section
$contactInfo = (new Section('Contact Information'))
    ->addContent('phone', $phoneField)
    ->addContent('fax', $faxField)
    ->addContent('email', $emailField);

# metabox
$metabox = (new AutoLoadingMetabox('section-test', 'Section Test', $postType))
    ->addContent('contact_info', $contactInfo)
    ->setNonce($nonce)
    ->hook();

################################################################################
#
################################################################################
