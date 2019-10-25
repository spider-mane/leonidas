<?php

namespace WebTheory\Saveyour\DataSchemes;

/**
 * DataScheme interfaces do not provide a list of required methods, but are
 * simply a means of ensuring that FormFields whose resulting POST variable
 * structure can only be paired with DataManagers that are designed to
 * anticipate and operate based on that structure.
 */
interface DataScheme
{
    // intentionally blank
}
