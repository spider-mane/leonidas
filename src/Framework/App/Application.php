<?php

namespace Leonidas\Framework\App;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Plugin\Plugin;
use Leonidas\Framework\WpExtension;
use Psr\Container\ContainerInterface;

class Application extends WpExtension implements WpExtensionInterface
{
    protected string $type = 'plugin';

    public function __construct(string $path, ContainerInterface $container)
    {
        $this->path = $path;
        $this->container = $container;
    }

    public function getUrl(): string
    {
        return $this->url ??= $this->config('app.url');
    }

    public function header(string $header): ?string
    {
        $headers = Plugin::headers(WPMU_PLUGIN_DIR . '/app.php');

        return $headers[$header] ?? null;
    }
}
