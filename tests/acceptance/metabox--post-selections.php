<?php

use Respect\Validation\Validator as v;
use WebTheory\Leonidas\Auth\Nonce;
use WebTheory\Leonidas\Fields\Selections\TaxonomyChecklistItems;
use WebTheory\Leonidas\Fields\Selections\TaxonomySelectOptions;
use WebTheory\Leonidas\Fields\Selections\TermQuerySelectOptions;
use WebTheory\Leonidas\Fields\TermChecklist;
use WebTheory\Leonidas\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use WebTheory\Leonidas\MetaBox\Field;
use WebTheory\Leonidas\MetaBox\MetaBox;
use WebTheory\Leonidas\MetaBox\Section;
use WebTheory\Leonidas\Screen;
use WebTheory\Saveyour\Controllers\FormFieldControllerBuilder;
use WebTheory\Saveyour\Fields\Select;
use WebTheory\Saveyour\Fields\Url;
use WebTheory\Taxtribute\Constrainer;
use WebTheory\Taxtribute\Model;
use WebTheory\Taxtribute\TermBasedPostMeta;

Screen::load('post', ['post_type' => 'wts_test_cpt_2'], function () {
    // exit(var_dump($_POST));

    ################################################################################
    # Base
    ################################################################################
    $test = 'Taxonomy Checklist Items';
    $postType = 'wts_test_cpt_2';
    $taxonomy = 'wts_test_tax';
    $taxName = get_taxonomy($taxonomy)->labels->name;

    $nonce = new Nonce('selection-nonce', 'save-selection');

    $metabox = (new MetaBox('selections-metabox', 'Selections Tests', $postType))
        ->setNonce($nonce)
        ->hook();

    $manager = (new PostMetaBoxFormSubmissionManager($postType))
        ->setNonce($nonce)
        ->hook();

    // $section = (new Section($taxName));
    // $metabox->addContent('test', $section);

    ################################################################################
    # Checklist
    ################################################################################
    $checklist = new TermChecklist($taxonomy, 'wts_tax_input');
    $checklistField = (new Field($checklist))->setLabel($test);

    $manager->addField($checklist);
    $metabox->addContent('taxtribute-checklist', $checklistField);

    ################################################################################
    # Post Query Select Options
    ################################################################################
    $options = new TaxonomySelectOptions($taxonomy);
    $formField = (new Select)->setSelectionProvider($options);
});
