<?php

namespace Tests\Suites\Extension;

use PHPUnit\Framework\TestCase;
use Tests\Ext\WpLoader;

class WpLoaderTest extends TestCase
{
    public const RUN_COUNT = 3;

    public static function setUpBeforeClass(): void
    {
        WpLoader::bootstrap();
    }

    public function blankProvider()
    {
        return array_fill(0, static::RUN_COUNT, []);
    }

    protected function assertFunctionExists(string $function): void
    {
        $this->assertTrue(function_exists($function), "Failed asserting that function $function exists");
    }

    protected function assertClassExists(string $class): void
    {
        $this->assertTrue(class_exists($class), "Failed asserting that class $class exists");
    }

    protected function assertFileIsLoaded(string $file): void
    {
        $this->assertContains($file, get_included_files(), "Failed asserting that file $file is loaded");
    }

    /**
     * @test
     */
    public function wordpress_is_loaded()
    {
        // check functions
        $this->assertFunctionExists('wp_scripts');
        $this->assertFunctionExists('add_filter');

        // check classes

        // check files
    }
}
