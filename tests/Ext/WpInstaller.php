<?php

namespace Tests\Ext;

use Tests\Ext\Manager\WpManager;

class WpInstaller
{
    /**
     * Installs WordPress for the purpose of the unit-tests
     *
     * @todo Reuse the init/load code in init.php
     */
    public static function installWordPress()
    {
        static::requireInstallDotPhp();

        return;

        // define('WP_INSTALLING', true);
        // static::loadRequiredFiles();
        // WpManager::resetServer();

        // echo 'Installing WordPress...' . PHP_EOL;

        // static::prepareDatabaseForInstallation();
        // static::doInstallation();

        if (static::isMultisite()) {
            echo 'Installing network...' . PHP_EOL;
            static::setUpForMultisite();
        }
    }

    protected static function requireInstallDotPhp()
    {
        static::loadRequiredFiles();
        WpManager::resetServer();

        echo 'Installing WordPress...' . PHP_EOL;

        static::prepareDatabaseForInstallation();

        $_GET['step'] = 2;

        $_POST['weblog_title'] = 'Plugin';
        $_POST['user_name'] = 'user';
        $_POST['admin_password'] = 'password';
        $_POST['admin_password2'] = 'password';
        $_POST['admin_email'] = 'user@example.com';
        $_POST['blog_public'] = null;

        require_once ABSPATH . '/wp-admin/install.php';
    }

    protected static function doInstallation()
    {
        wp_install('Plugin', 'admin', 'name@example.com', true, null, 'password');
    }

    protected static function loadRequiredFiles()
    {
        require_once static::getCmdArg('config');

        // require_once ABSPATH . '/wp-includes/wp-db.php';
        require_once ABSPATH . '/wp-settings.php';
        require_once ABSPATH . '/wp-admin/includes/upgrade.php';
    }

    protected static function prepareDatabaseForInstallation()
    {
        global $wpdb;

        // $db = (!defined('USE_MYSQL') || false === USE_MYSQL) ? FQDB : DB_NAME;

        // $wpdb->select($db, $wpdb->dbh);
        $wpdb->select(DB_NAME, $wpdb->dbh);
        $wpdb->query('SET foreign_key_checks = 0');

        foreach ($wpdb->tables() as $table => $prefixedTable) {
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $wpdb->query("DROP TABLE IF EXISTS $prefixedTable");
        }

        foreach ($wpdb->tables('ms_global') as $table => $prefixedTable) {
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $wpdb->query("DROP TABLE IF EXISTS $prefixedTable");

            // We need to create references to ms global tables.
            if (static::isMultisite()) {
                $wpdb->$table = $prefixedTable;
            }
        }

        $wpdb->query('SET foreign_key_checks = 1');
    }

    protected static function setUpForMultisite()
    {
        global $wp_rewrite;

        $title = 'Plugin Network';
        $domain = preg_replace('/(^\w+:|^)\/\//', '', WP_HOME);
        $subdomainInstall = false;

        delete_option('permalink_structure');
        define('WP_INSTALLING_NETWORK', true);
        install_network();

        $error = populate_network(1, $domain, 'name@example.com', $title, '/', $subdomainInstall);

        if (is_wp_error($error)) {
            wp_die($error);
        }

        $wp_rewrite->set_permalink_structure('');
    }

    protected static function isMultisite(): bool
    {
        $multisite = static::getCmdArg('m');

        return isset($multisite);
    }

    protected static function getCmdArg(string $arg)
    {
        $args = getopt('m', ['config:']);

        return $args[$arg] ?? null;
    }
}
