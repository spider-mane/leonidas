<?php

namespace Tests\Ext\Assert\Traits;

use IXR_Error;
use PHPUnit\Framework\Assert;
use Tests\Ext\Assert\Util\WpScriptFactory;
use Tests\Ext\Assert\Util\WpStyleFactory;

trait WpAssertTrait
{
    /**
     * Asserts that the given value is an instance of WP_Error.
     *
     * @param mixed  $actual  The value to check.
     * @param string $message Optional. Message to display when the assertion fails.
     */
    public static function assertWPError($actual, $message = '')
    {
        Assert::assertInstanceOf('WP_Error', $actual, $message);
    }

    /**
     * Asserts that the given value is not an instance of WP_Error.
     *
     * @param mixed  $actual  The value to check.
     * @param string $message Optional. Message to display when the assertion fails.
     */
    public static function assertNotWPError($actual, $message = '')
    {
        if ('' === $message && is_wp_error($actual)) {
            $message = $actual->get_error_message();
        }
        Assert::assertNotInstanceOf('WP_Error', $actual, $message);
    }

    /**
     * Asserts that the given value is an instance of IXR_Error.
     *
     * @param mixed  $actual  The value to check.
     * @param string $message Optional. Message to display when the assertion fails.
     */
    public static function assertIXRError($actual, $message = '')
    {
        Assert::assertInstanceOf('IXR_Error', $actual, $message);
    }

    /**
     * Asserts that the given value is not an instance of IXR_Error.
     *
     * @param mixed  $actual  The value to check.
     * @param string $message Optional. Message to display when the assertion fails.
     */
    public static function assertNotIXRError($actual, $message = '')
    {
        if ('' === $message && $actual instanceof IXR_Error) {
            $message = $actual->message;
        }
        Assert::assertNotInstanceOf('IXR_Error', $actual, $message);
    }

    /**
     * Checks each of the WP_Query is_* functions/properties against expected boolean value.
     *
     * Any properties that are listed by name as parameters will be expected to be true; all others are
     * expected to be false. For example, assertQueryTrue( 'is_single', 'is_feed' ) means is_single()
     * and is_feed() must be true and everything else must be false to pass.
     *
     * @since 2.5.0
     * @since 3.8.0 Moved from `Tests_Query_Conditionals` to `WP_UnitTestCase`.
     * @since 5.3.0 Formalized the existing `...$prop` parameter by adding it
     *              to the function signature.
     *
     * @param string ...$prop Any number of WP_Query properties that are expected to be true for the current request.
     */
    public function assertQueryTrue(...$prop)
    {
        global $wp_query;

        $all = [
            'is_404',
            'is_admin',
            'is_archive',
            'is_attachment',
            'is_author',
            'is_category',
            'is_comment_feed',
            'is_date',
            'is_day',
            'is_embed',
            'is_feed',
            'is_front_page',
            'is_home',
            'is_privacy_policy',
            'is_month',
            'is_page',
            'is_paged',
            'is_post_type_archive',
            'is_posts_page',
            'is_preview',
            'is_robots',
            'is_favicon',
            'is_search',
            'is_single',
            'is_singular',
            'is_tag',
            'is_tax',
            'is_time',
            'is_trackback',
            'is_year',
        ];

        foreach ($prop as $true_thing) {
            Assert::assertContains($true_thing, $all, "Unknown conditional: {$true_thing}.");
        }

        $passed = true;
        $message = '';

        foreach ($all as $query_thing) {
            $result = is_callable($query_thing) ? call_user_func($query_thing) : $wp_query->$query_thing;

            if (in_array($query_thing, $prop, true)) {
                if (!$result) {
                    $message .= $query_thing . ' is false but is expected to be true. ' . PHP_EOL;
                    $passed = false;
                }
            } elseif ($result) {
                $message .= $query_thing . ' is true but is expected to be false. ' . PHP_EOL;
                $passed = false;
            }
        }

        if (!$passed) {
            Assert::fail($message);
        }
    }

    // ADDED ===========================================================================================================

    public static function assertScriptRegistered(array $data, string $message = ''): void
    {
        $handle = $data['handle'];
        $registered = wp_scripts()->registered;
        $script = $registered[$handle] ?? null;

        $message = $message ?: "Failed asserting that script $handle is registered";

        if ($script) {
            Assert::assertEquals(WpScriptFactory::create($data), $script, $message);
        } else {
            Assert::assertArrayHasKey($handle, $registered, $message);
        }
    }

    public static function assertScriptNotRegistered(array $data, string $message = ''): void
    {
        $handle = $data['handle'];
        $registered = wp_scripts()->registered;
        $script = $registered['handle'] ?? null;

        $message = $message ?: "Failed asserting that script $handle is not registered";

        if ($script) {
            Assert::assertNotEquals(WpScriptFactory::create($data), $script, $message);
        } else {
            Assert::assertArrayNotHasKey($handle, $registered, $message);
        }
    }

    public static function assertStyleRegistered(array $data, string $message = ''): void
    {
        $handle = $data['handle'];
        $registered = wp_styles()->registered;
        $style = $registered[$handle] ?? null;

        $message = $message ?: "Failed asserting that style $handle is registered";

        if ($style) {
            Assert::assertEquals(WpStyleFactory::create($data), $style, $message);
        } else {
            Assert::assertArrayHasKey($handle, $registered, $message);
        }
    }

    public static function assertStyleNotRegistered(array $data, string $message = ''): void
    {
        $handle = $data['handle'];
        $registered = wp_styles()->registered;
        $style = $registered['handle'] ?? null;

        $message = $message ?: "Failed asserting that style $handle is not registered";

        if ($style) {
            Assert::assertNotEquals(WpStyleFactory::create($data), $style, $message);
        } else {
            Assert::assertArrayNotHasKey($handle, $registered, $message);
        }
    }
}
