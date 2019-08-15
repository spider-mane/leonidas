<?php

use Backalley\Form\Fields\Input;
use Respect\Validation\Validator as v;
use Backalley\WordPress\MetaBox\MetaBox;
use Backalley\WordPress\MetaBox\Section;
use Backalley\Wordpress\MetaBox\FieldGrid;
use Backalley\Form\Controllers\FormFieldController;
use Backalley\Wordpress\Fields\Managers\PostMetaFieldManager;
use Backalley\Wordpress\Forms\Controllers\PostMetaBoxFormSubmissionManager;

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

        $element = (new Input)
            ->setId("ba--{$daySlug}--{$timeSlug}")
            ->setType("time")
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
