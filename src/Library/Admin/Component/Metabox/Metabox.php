<?php

namespace Leonidas\Library\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCapsuleInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Core\Http\Policy\NoPolicy;
use Psr\Http\Message\ServerRequestInterface;
use WP_Screen;

class Metabox implements MetaboxInterface
{
    use CanBeRestrictedTrait;

    protected string $id;

    protected string $title;

    /**
     * @var string|array<string>|WP_Screen
     */
    protected string|array|WP_Screen $screen;

    protected string $context = 'advanced';

    protected string $priority = 'default';

    protected array $args;

    protected MetaboxCapsuleInterface $capsule;

    public function __construct(
        string $id,
        string $title,
        string|array|WP_Screen $screen,
        ?string $context = null,
        ?string $priority = null,
        array $args = [],
        ?MetaboxCapsuleInterface $capsule = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->screen = $screen;
        $this->context = $context ?? $this->context;
        $this->priority = $priority ?? $this->priority;
        $this->args = $args;
        $this->capsule = $capsule ?? new EmptyMetaboxCapsule();

        $this->policy = $this->capsule->policy($this) ?? new NoPolicy();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|array<string>|WP_Screen
     */
    public function getScreen(): string|array|WP_Screen
    {
        return $this->screen;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->capsule->layout($this)->renderComponent($request);
    }
}
