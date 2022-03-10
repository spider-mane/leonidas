<?php

namespace Leonidas\Contracts\Admin\Screen;

interface ScreenInterface
{
    public function getAction(): string;

    public function getBase(): string;

    public function getId(): string;

    public function isNetwork(): bool;

    public function isUser(): bool;

    public function parentBase(): ?string;

    public function parentFile(): ?string;

    public function postType(): ?string;

    public function taxonomy(): ?string;
}
