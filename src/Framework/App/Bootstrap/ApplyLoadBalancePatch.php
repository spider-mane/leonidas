<?php

namespace Leonidas\Framework\App\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;

class ApplyLoadBalancePatch implements ExtensionBootProcessInterface
{
    /**
     * Allows WordPress to detect HTTPS when used behind a reverse proxy or a load balancer
     *
     * @link https://developer.wordpress.org/reference/functions/is_ssl/
     */
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        if (
            isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
            && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
        ) {
            $_SERVER['HTTPS'] = 'on';
        }
    }
}
