<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\ActionInterface;
use WebContent\Copy\Contracts\BodyInterface;
use WebContent\Copy\Contracts\CopyInterface;
use WebContent\Copy\Contracts\HeadingInterface;
use WebContent\Copy\Contracts\KickerInterface;
use WebContent\Copy\Contracts\VisualMediaInterface;
use WebContent\Copy\Contracts\SubheadingInterface;

class Copy implements CopyInterface
{
    public function __construct(
        protected ?KickerInterface $kicker = null,
        protected ?HeadingInterface $heading = null,
        protected ?SubheadingInterface $subheading = null,
        protected ?BodyInterface $body = null,
        protected ?ActionInterface $action = null,
        protected ?VisualMediaInterface $media = null,
    ) {
        //
    }

    public function getKicker(): ?KickerInterface
    {
        return $this->kicker;
    }

    public function getHeading(): ?HeadingInterface
    {
        return $this->heading;
    }

    public function getSubheading(): ?SubheadingInterface
    {
        return $this->subheading;
    }

    public function getBody(): ?BodyInterface
    {
        return $this->body;
    }

    public function getAction(): ?ActionInterface
    {
        return $this->action;
    }

    public function getMedia(): ?VisualMediaInterface
    {
        return $this->media;
    }

    public function jsonSerialize(): array
    {
        return [
            'kicker' => $this->getKicker(),
            'heading' => $this->getHeading(),
            'subheading' => $this->getSubheading(),
            'body' => $this->getBody(),
            'action' => $this->getAction(),
            'media' => $this->getMedia(),
        ];
    }
}
