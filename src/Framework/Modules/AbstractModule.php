<?php

namespace Leonidas\Framework\Modules;

use GuzzleHttp\Psr7\ServerRequest;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractModule implements ModuleInterface
{
    /**
     * @var WpExtensionInterface
     */
    protected WpExtensionInterface $extension;

    /**
     * @param WpExtensionInterface $extension
     */
    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
    }

    /**
     * Get the value of extension
     *
     * @return WpExtensionInterface
     */
    protected function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }

    /**
     * Get the value of extension
     *
     * @return ServerRequestInterface
     */
    protected function getServerRequest(): ServerRequestInterface
    {
        if ($this->extension->has(ServerRequestInterface::class)) {
            return $this->extension->get(ServerRequestInterface::class);
        }

        return ServerRequest::fromGlobals();
    }
}
