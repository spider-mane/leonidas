<?php

/**
 * Disable WordPress setting ini error directives for more fine tuned control.
 *
 * This script allows use of a constant `WP_DEBUG_MODE_CHECKS` rather than the
 * cumbersome method defined by WordPress and used here.
 *
 * @see wp_debug_mode() in wp-includes/load.php
 * @link https://developer.wordpress.org/reference/hooks/enable_wp_debug_mode_checks/
 */

$GLOBALS['wp_filter']['enable_wp_debug_mode_checks'] = [
    PHP_INT_MAX => [
        [
            'accepted_args' => 0,
            'function' => function () {
                return !defined("WP_DEBUG_MODE_CHECKS") || true === WP_DEBUG_MODE_CHECKS;
            },
        ],
    ],
];
