<?php

use WebTheory\Leonidas\Auth\Nonce;
use WebTheory\Leonidas\Fields\Managers\PostMetaFieldManager;
use WebTheory\Leonidas\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use WebTheory\Leonidas\MetaBox\FieldGrid;
use WebTheory\Leonidas\MetaBox\MetaBox;
use WebTheory\Leonidas\MetaBox\Section;
use WebTheory\Saveyour\Controllers\FormFieldController;
use WebTheory\Saveyour\Fields\Time;

################################################################################

$postType = 'wts_test_cpt_2';
$nonce = new Nonce('wts-metabox', 'edit_' . $postType);

$metabox = (new MetaBox('wts_hours', 'Hours', $postType))
    ->setNonce($nonce)
    ->hook();

$formController = (new PostMetaBoxFormSubmissionManager($postType))
    ->setNonce($nonce)
    ->hook();

// rows
$days = [
    'Sunday',
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday'
];

// columns
$times = ['Open', 'Close'];

$fieldGrid = (new FieldGrid)->setColumnWidth(2);

/**
 * populate $fieldGrid and
 */
foreach ($times as $time) {
    $fieldGrid->addColumn(strtolower($time), $time);
}

foreach ($days as $day) {
    $daySlug = strtolower($day);
    $fieldGrid->addRow($daySlug, $day);

    foreach ($times as $time) {
        $timeSlug = strtolower($time);
        $slug = "{$daySlug}_{$timeSlug}";

        $element = (new Time)
            ->setId("ba--{$daySlug}--{$timeSlug}")
            ->setName($slug);

        $data = (new PostMetaFieldManager("ba_location_hours__{$slug}"));

        $field = (new FormFieldController($slug, $element, $data));

        /**
         * populate form submission manager with each field
         *
         *  @var PostMetaBoxFormSubmissionManager $formController
         */
        $formController->addField($field);

        $fieldGrid->addField($daySlug, $timeSlug, $field);
    }
}

// create section and add fieldgrid as content
$section = (new Section('Hours'))->addContent('hours', $fieldGrid);

//
$metabox->addContent('hours', $section);
