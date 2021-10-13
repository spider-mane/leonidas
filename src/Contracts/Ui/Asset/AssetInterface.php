<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Http\ConstrainerInterface;
use Psr\Http\Message\ServerRequestInterface;

interface AssetInterface
{
    /**
     * @return string
     */
    public function getHandle(): string;

    /**
     * @return string|bool
     */
    public function getSrc();

    /**
     * @return string[]
     */
    public function getDependencies(): ?array;

    /**
     * @return string|bool|null
     */
    public function getVersion();

    public function getAttributes(): array;

    public function getCrossorigin(): ?string;

    public function shouldBeRegistered(ServerRequestInterface $request): bool;

    public function shouldBeEnqueued(ServerRequestInterface $request): bool;

    public function toHtml(): string;
}
