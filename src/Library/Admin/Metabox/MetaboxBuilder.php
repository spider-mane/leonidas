<?php

namespace Library\Admin\Metabox;

use Leonidas\Contracts\Admin\Components\MetaboxBuilderInterface;
use Leonidas\Contracts\Admin\Components\MetaboxInterface;
use Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Library\Admin\Metabox\Metabox;

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

    protected ConstrainerCollectionInterface $constraints;

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

    public function constraints(ConstrainerCollectionInterface $constraints)
    {
        $this->constraints = $constraints;

        return $this;
    }

    public function layout(MetaboxLayoutInterface $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    public function get(): MetaboxInterface
    {
        $metabox = new Metabox($this->id, $this->title, $this->layout);

        $metabox->setScreen($this->screen);
        $metabox->setContext($this->context);
        $metabox->setPriority($this->priority);
        $metabox->setArgs($this->args);
        $metabox->setConstraints($this->constraints);

        return $metabox;
    }

    public static function for(string $id)
    {
        return new static($id);
    }
}
