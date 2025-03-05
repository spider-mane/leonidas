<?php

namespace WebContent\Copy\Contracts;

interface CopyInterface extends ViewDataInterface
{
    public function getKicker(): ?KickerInterface;

    public function getHeading(): ?HeadingInterface;

    public function getSubheading(): ?SubheadingInterface;

    public function getBody(): ?BodyInterface;

    public function getAction(): ?ActionInterface;

    public function getMedia(): ?VisualMediaInterface;
}
