<?php

use WebTheory\Leonidas\Library\Core\Auth\Nonce;
use WebTheory\Leonidas\Library\Admin\Fields\TermChecklist;
use WebTheory\Leonidas\Library\Admin\Fields\TermSelect2;
use WebTheory\Leonidas\Library\Admin\Fields\TermSelect;
use WebTheory\Leonidas\Library\Admin\Forms\Controllers\PostMetaboxFormSubmissionManager;
use WebTheory\Leonidas\Library\Admin\Metabox\Components\Field;
use WebTheory\Leonidas\Library\Admin\Metabox\AutoLoadingMetabox;
use WebTheory\Leonidas\Library\Admin\Screen;

Screen::load('post', ['post_type' => 'wts_test_cpt_2'], function () {
    // exit(var_dump($_POST));

    ################################################################################
    # Base
    ################################################################################
    $test = 'Taxonomy Checklist';
    $postType = 'wts_test_cpt_2';
    $taxonomy = 'wts_test_tax';
    $taxName = get_taxonomy($taxonomy)->labels->name;

    $nonce = new Nonce('selection-nonce', 'save-selection');

    $metabox = (new AutoLoadingMetabox('selections-metabox', 'Selections Tests', $postType))
        ->setNonce($nonce)
        ->hook();

    $manager = (new PostMetaboxFormSubmissionManager($postType))
        ->setTokenManager($nonce)
        ->hook();

    ################################################################################
    # Checklist
    ################################################################################
    $checklist = new TermChecklist($taxonomy, 'wts_tax_input');
    $checklistField = (new Field($checklist))->setLabel($test);

    $manager->addField($checklist);
    $metabox->addContent('taxonomy-checklist', $checklistField);

    ################################################################################
    # Post Query Select Options
    ################################################################################
    $options = [
        'multiple' => true,
        'class' => ['regular-text']
    ];

    $select = new TermSelect($taxonomy, 'wts_tax_input_2', $options);
    $selectField = (new Field($select))->setLabel('Taxonomy Select');

    $manager->addField($select);
    $metabox->addContent('taxonomy-select', $selectField);

    ################################################################################
    # Term Select2
    ################################################################################
    $options = [
        'multiple' => true,
    ];

    $select2 = new TermSelect2($taxonomy, 'wts_tax_input_3', $options);
    $select2Field = (new Field($select2))->setLabel('Taxonomy Select2');

    $manager->addField($select2);
    $metabox->addContent('taxonomy-select2', $select2Field);
});
