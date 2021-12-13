<?php

namespace Tests\Suites\Extension;

use Faker\Factory;
use Tests\Ext\WpLoadedTestCase;

class WordpressLoadedTestCaseTest extends WpLoadedTestCase
{
    public const RUN_COUNT = 3;

    public function blankProvider()
    {
        return array_fill(0, static::RUN_COUNT, []);
    }

    /**
     * @test
     * @dataProvider blankProvider
     */
    public function wp_scripts_are_refreshed_on_each_test_run()
    {
        $faker = Factory::create();

        $data = [
            'handle' => 'wp-loaded-dummy-script',
            'src' => '/assets/dist/js/dummy-script.js',
            'deps' => ['johnny-dep'],
            'ver' => '1.9.7',
            'in_footer' => true,
        ];

        $this->assertScriptNotRegistered($data);

        wp_register_script(
            $data['handle'],
            $data['src'],
            $data['deps'],
            $data['ver'],
            $data['in_footer']
        );

        $this->assertScriptRegistered($data);
    }

    /**
     * @test
     * @dataProvider blankProvider
     */
    public function wp_styles_are_refreshed_on_each_test_run()
    {
        $data = [
            'handle' => 'wp-loaded-dummy-style',
            'src' => '/assets/dist/js/dummy-style.js',
            'deps' => ['johnny-dep'],
            'ver' => '1.9.7',
            'media' => 'print',
        ];

        $this->assertStyleNotRegistered($data);

        wp_register_style(
            $data['handle'],
            $data['src'],
            $data['deps'],
            $data['ver'],
            $data['media']
        );

        $this->assertStyleRegistered($data);
    }
}
