<?php

use WebTheory\Saveyour\Controllers\FormFieldController;
use WebTheory\Saveyour\Fields\Time;
use WebTheory\WordPress\MetaBox\MetaBox;
use WebTheory\WordPress\MetaBox\Section;
use WebTheory\WordPress\Fields\Managers\PostMetaFieldManager;
use WebTheory\WordPress\Forms\Controllers\PostMetaBoxFormSubmissionManager;
use WebTheory\WordPress\MetaBox\FieldGrid;
use Respect\Validation\Validator as v;

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

/** @var MetaBox $metabox */
$metabox->addContent('hours', $section);
