<?php

namespace Tests\Ext;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;
use Tests\Ext\Manager\WpManager;
use WebTheory\WpCliUtil\WpCliRunner;
use WebTheory\WpCliUtil\WpCliUtil;

class WpLoader implements BeforeFirstTestHook, AfterLastTestHook
{
    /**
     * @var array
     */
    protected $testsuites = [];

    public function __construct($testsuites = [])
    {
        $this->testsuites = $testsuites;
    }

    public function executeBeforeFirstTest(): void
    {
        static::bootstrap();
    }

    public function executeAfterLastTest(): void
    {
        //
    }

    private static function init(array $testsuites)
    {
        $shellArgs = getopt('', ['testsuite:']);
        $testsuite = $shellArgs['testsuite'] ?? null;

        if (!$testsuite || !in_array($testsuite, $testsuites)) {
            return;
        }

        static::bootstrap();
    }

    public static function bootstrap(): void
    {
        if (!static::wpIsInstalled()) {
            static::installWordPress();
        }

        static::loadWordPress();
    }

    public static function installWordPress(): void
    {
        echo "Preparing WordPress for first run...\n";

        WpCliRunner::installWordPress();

        echo "\n";
    }

    public static function loadWordPress(): void
    {
        $path = static::getInstallPath();

        WpManager::resetHttpGlobals();

        require_once getcwd() . "/$path/wp-blog-header.php";
    }

    public static function prepareStateForTesting(): void
    {
        WpManager::resetWordPress();
    }

    public static function wpIsInstalled(): bool
    {
        return WpCliRunner::wpIsInstalled();
    }

    public static function getCliConfig(): array
    {
        return WpCliUtil::getCliConfig();
    }

    public static function getInstallPath(): string
    {
        return WpCliUtil::getInstallPath();
    }

    public static function getCliCmd(): string
    {
        return WpCliUtil::getCliCmd();
    }

    // public static function isMultisite(): bool
    // {
    //     return false;
    //     return defined('WP_ALLOW_MULTISITE ') && WP_ALLOW_MULTISITE  === true;
    // }

    // protected static function runWordPressInstallation(string $configFilePath): void
    // {
    //     $php = 'php';
    //     $install = escapeshellarg(dirname(__FILE__) . '/bin/install.php');
    //     $config = escapeshellarg($configFilePath);

    //     $cmd = "$php $install --config $config";

    //     if (static::isMultisite()) {
    //         $cmd .= " -m";
    //     }

    //     system($cmd, $returnVal);

    //     if (0 !== $returnVal) {
    //         exit($returnVal);
    //     }
    // }
}
