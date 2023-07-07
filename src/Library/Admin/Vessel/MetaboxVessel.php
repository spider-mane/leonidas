<?php

namespace Leonidas\Library\Admin\Vessel;

use Leonidas\Contracts\Admin\Component\Capsule\MetaboxCapsuleInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Psr\Http\Message\ServerRequestInterface;
use WP_Screen;

class MetaboxVessel implements MetaboxInterface
{
    use CanBeRestrictedTrait;

    public function __construct(protected MetaboxCapsuleInterface $capsule)
    {
        $this->policy = $this->capsule->policy();
    }

    public function getId(): string
    {
        return $this->capsule->id();
    }

    public function getTitle(): string
    {
        return $this->capsule->title();
    }

    public function getScreen(): string|array|WP_Screen
    {
        return $this->capsule->screen();
    }

    public function getPriority(): string
    {
        return $this->capsule->priority();
    }

    public function getContext(): string
    {
        return $this->capsule->context();
    }

    public function getArgs(): array
    {
        return $this->getArgs();
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->capsule->layout()->renderComponent($request);
    }
}
