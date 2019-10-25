<?php

namespace WebTheory\Saveyour\DataSchemes;

/**
 * {@inheritDoc}
 *
 * The IO DataScheme for form fields means that it creates a post variable or
 * array of post variables structured in the form of an array where a reference
 * to a data object is present as the key and the value is an indicator as to
 * whether or not the data object has been selected. This would normally be
 * achieved by including a hidden input that has the same name as a selectable
 * input where the selectable inputs value indicates that it has been selected
 * and the hidden inputs value indicates that it has been ommited.
 */
interface IO extends DataScheme
{
    // intentionally blank
}
