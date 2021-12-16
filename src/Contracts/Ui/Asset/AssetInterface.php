<?php

namespace Leonidas\Contracts\Ui\Asset;

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
     * @return null|string[]
     */
    public function getDependencies(): ?array;

    /**
     * @return string|bool|null
     */
    public function getVersion();

    public function getAttributes(): array;

    public function getCrossorigin(): ?string;

    public function shouldBeEnqueued(): bool;

    public function shouldBeLoaded(ServerRequestInterface $request): bool;
}
