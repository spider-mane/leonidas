<?php

/**
 * This file is part of the Leonidas WordPress plugin.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package leonidas/leonidas
 * @version 0.15.0
 * @license GPL-3.0-or-later
 * @copyright Copyright (C) 2021 Chris Williams, All rights reserved.
 * @link https://github.com/spider-mane/leonidas
 * @author Chris Williams <spider.mane.web@gmail.com>
 *
 * @wordpress-plugin
 * Plugin Name: Leonidas
 * Plugin URI: https://github.com/spider-mane/leonidas
 * Description: Theme and plugin framework with enhanced WordPress abstraction api.
 * Version: 0.15.0
 * Requires at least: 5.0
 * Requires PHP: 7.3
 * Author: Chris Williams
 * Author URI: https://github.com/spider-mane
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: leonidas
 * Domain Path: /lang
 */

defined('ABSPATH') || exit;

call_user_func(function () {
    require __DIR__ . '/boot/init.php';
    Leonidas\Plugin\Launcher::init(__FILE__);
});
