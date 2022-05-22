<?php

namespace Leonidas\Framework\Abstracts;

use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Throwable;

trait InitsServerRequestTrait
{
    use UtilizesExtensionTrait;

    protected function getServerRequest(): ServerRequestInterface
    {
        if ($this->hasService($service = $this->serverRequestServiceId())) {
            return $this->getService($service);
        }

        throw $this->serverRequestNotFoundException();
    }

    protected function serverRequestNotFoundException(): Throwable
    {
        $interface = ServerRequestInterface::class;

        return new RuntimeException(
            "Instance of $interface could not be found. Make sure you provide an instance of $interface in your container."
        );
    }

    protected function serverRequestServiceId(): string
    {
        return ServerRequestInterface::class;
    }
}
