<?php

/**
 * This file is part of the WebTheory Leonidas package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Leonidas
 * @license GPL-3.0-or-later
 * @copyright Copyright (C) Chris Williams, All rights reserved.
 * @link https://github.com/spider-mane/leonidas
 * @author Chris Williams <spider.mane.web@gmail.com>
 *
 * @wordpress-plugin
 * Plugin Name: Leonidas
 * Version: 0.11.0
 * Text Domain: leonidas
 * Github URI: spider-mane/leonidas
 * Description: Theme and plugin framework with enhanced WordPress abstraction api.
 */

use Leonidas\Framework\Helpers\Plugin;
use Leonidas\Plugin\Leonidas;

defined('ABSPATH') || exit;

require __DIR__ . '/boot/init.php';

Leonidas::init(
    Plugin::base(__FILE__),
    Plugin::path(__DIR__),
    Plugin::url(__DIR__),
);
