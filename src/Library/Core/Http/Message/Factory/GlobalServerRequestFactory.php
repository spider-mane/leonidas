<?php

namespace Leonidas\Library\Core\Http\Message\Factory;

use Leonidas\Contracts\Http\ServerRequest\GlobalServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

class GlobalServerRequestFactory implements GlobalServerRequestFactoryInterface
{
    protected ServerRequestFactory $requestFactory;

    protected StreamFactoryInterface $streamFactory;

    protected UploadedFileFactoryInterface $fileFactory;

    protected UriFactoryInterface $uriFactory;

    public function __construct(
        ServerRequestFactory $requestFactory,
        UriFactoryInterface $uriFactory,
        StreamFactoryInterface $streamFactory,
        UploadedFileFactoryInterface $fileFactory
    ) {
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->streamFactory = $streamFactory;
        $this->fileFactory = $fileFactory;
    }

    public function create(): ServerRequestInterface
    {
        $request = $this->requestFactory->createServerRequest(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_SERVER['REQUEST_URI'],
            $_SERVER
        );

        foreach (getallheaders() as $name => $value) {
            $request->withHeader($name, $value);
        }

        return $request
            ->withProtocolVersion($_SERVER['SERVER_PROTOCOL'])
            ->withCookieParams($_COOKIE)
            ->withQueryParams($_GET)
            ->withParsedBody($_POST)
            ->withUploadedFiles($_FILES);
    }
}
