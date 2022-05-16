<?php

namespace Leonidas\Library\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxBuilderInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class MetaboxBuilder implements MetaboxBuilderInterface
{
    protected string $id;

    protected string $title;

    /**
     * @var string|string[]|WP_Screen
     */
    protected $screen;

    protected ?string $context = 'advanced';

    protected ?string $priority = 'default';

    protected ?array $args = [];

    protected MetaboxLayoutInterface $layout;

    protected ServerRequestPolicyInterface $policy;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(string $id)
    {
        $this->id = $id;

        return $this;
    }

    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string|string[]|WP_Screen $screen
     */
    public function screen($screen)
    {
        $this->screen = $screen;

        return $this;
    }

    public function context(?string $context)
    {
        $this->context = $context;

        return $this;
    }

    public function priority(?string $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function args(?array $args)
    {
        $this->args = $args;

        return $this;
    }

    public function policy(ServerRequestPolicyInterface $policy)
    {
        $this->policy = $policy;

        return $this;
    }

    public function layout(MetaboxLayoutInterface $layout)
    {
        $this->layout = $layout;

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
            $this->layout,
            $this->policy
        );
    }

    public static function for(string $id)
    {
        return new static($id);
    }
}
