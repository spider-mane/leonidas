<?php

use WebTheory\Leonidas\Core\Auth\Nonce;
use WebTheory\Leonidas\Admin\Fields\Managers\PostMetaFieldManager;
use WebTheory\Leonidas\Admin\Forms\Controllers\PostMetaboxFormSubmissionManager;
use WebTheory\Leonidas\Admin\Metabox\Components\FieldGrid;
use WebTheory\Leonidas\Admin\Metabox\AutoLoadingMetabox;
use WebTheory\Leonidas\Admin\Metabox\Components\Section;
use WebTheory\Saveyour\Controllers\FormFieldController;
use WebTheory\Saveyour\Fields\Time;

################################################################################

$postType = 'wts_test_cpt_2';
$nonce = new Nonce('wts-metabox', 'edit_' . $postType);

$metabox = (new AutoLoadingMetabox('wts_hours', 'Hours', $postType))
    ->setNonce($nonce)
    ->hook();

$formController = (new PostMetaboxFormSubmissionManager($postType))
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
         *  @var PostMetaboxFormSubmissionManager $formController
         */
        $formController->addField($field);

        $fieldGrid->addField($daySlug, $timeSlug, $field);
    }
}

// create section and add fieldgrid as content
$section = (new Section('Hours'))->addContent('hours', $fieldGrid);

//
$metabox->addContent('hours', $section);
