<?php

namespace Leonidas\Library\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxBuilderInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCapsuleInterface;
use WP_Screen;

class MetaboxBuilder implements MetaboxBuilderInterface
{
    protected string $id;

    protected string $title;

    /**
     * @var string|array<string>|WP_Screen
     */
    protected string|array|WP_Screen $screen;

    protected ?string $context = 'advanced';

    protected ?string $priority = 'default';

    protected ?array $args = [];

    protected ?MetaboxCapsuleInterface $capsule;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function screen(string|array|WP_Screen $screen): static
    {
        $this->screen = $screen;

        return $this;
    }

    public function context(?string $context): static
    {
        $this->context = $context;

        return $this;
    }

    public function priority(?string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function args(?array $args): static
    {
        $this->args = $args;

        return $this;
    }

    public function capsule(?MetaboxCapsuleInterface $capsule): static
    {
        $this->capsule = $capsule;

        return $this;
    }

    public function get(): Metabox
    {
        return new Metabox(
            $this->id,
            $this->title,
            $this->screen,
            $this->context,
            $this->priority,
            $this->args,
            $this->capsule
        );
    }

    public static function for(string $id): static
    {
        return new static($id);
    }
}
