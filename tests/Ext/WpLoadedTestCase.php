<?php

namespace Tests\Ext;

use PHPUnit\Framework\TestCase;
use PHPUnit\Util\GlobalState;
use Tests\Ext\Assert\Traits\AssertTrait;
use Tests\Ext\Assert\Traits\WpAssertTrait;
use Tests\Ext\Manager\Traits\WpManagerTrait;

class WpLoadedTestCase extends TestCase
{
    use AssertTrait;
    use WpAssertTrait;
    use WpManagerTrait;

    /**
     * Runs the routine before setting up all tests.
     */
    public static function setUpBeforeClass(): void
    {
        WpLoader::bootstrap();
        parent::setUpBeforeClass();
    }

    /**
     * Runs the routine after all tests have been run.
     */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        // static::resetDatabase();
        // static::flushCache();
        // static::commitTransaction();
    }

    /**
     * Runs the routine before each test is executed.
     */
    public function setUp(): void
    {
        $this->resetWordPress();
    }

    /**
     * After a test method runs, resets any state in WordPress the test method might have changed.
     */
    public function tearDown(): void
    {
        $this->restoreCurrentBlog();
    }

    /**
     * Allows tests to be skipped when Multisite is not in use.
     *
     * Use in conjunction with the ms-required group.
     */
    public function skipWithoutMultisite()
    {
        if (!is_multisite()) {
            $this->markTestSkipped('Test only runs on Multisite');
        }
    }

    /**
     * Allows tests to be skipped when Multisite is in use.
     *
     * Use in conjunction with the ms-excluded group.
     */
    public function skipWithMultisite()
    {
        if (is_multisite()) {
            $this->markTestSkipped('Test does not run on Multisite');
        }
    }

    /**
     * Allows tests to be skipped if the HTTP request times out.
     *
     * @param array|WP_Error $response HTTP response.
     */
    public function skipTestOnTimeout($response)
    {
        if (!is_wp_error($response)) {
            return;
        }
        if ('connect() timed out!' === $response->get_error_message()) {
            $this->markTestSkipped('HTTP timeout');
        }

        if (false !== strpos($response->get_error_message(), 'timed out after')) {
            $this->markTestSkipped('HTTP timeout');
        }

        if (0 === strpos($response->get_error_message(), 'stream_socket_client(): unable to connect to tcp://s.w.org:80')) {
            $this->markTestSkipped('HTTP timeout');
        }
    }

    /**
     * Custom preparations for the PHPUnit process isolation template.
     *
     * When restoring global state between tests, PHPUnit defines all the constants that were already defined, and then
     * includes included files. This does not work with WordPress, as the included files define the constants.
     *
     * This method defines the constants after including files.
     *
     * @param Text_Template $template The template to prepare.
     */
    public function prepareTemplate(Text_Template $template)
    {
        $template->setVar(['constants' => '']);
        $template->setVar(['wp_constants' => GlobalState::getConstantsAsString()]);
        parent::prepareTemplate($template);
    }
}
