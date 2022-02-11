<?php

namespace Leonidas\Library\Admin\Metabox;

use Leonidas\Contracts\Admin\Components\MetaboxInterface;
use Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use Leonidas\Traits\CanBeRestrictedTrait;
use Psr\Http\Message\ServerRequestInterface;

class Metabox implements MetaboxInterface
{
    use CanBeRestrictedTrait;

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

    public function __construct(string $id, string $title, MetaboxLayoutInterface $layout)
    {
        $this->id = $id;
        $this->title = $title;
        $this->layout = $layout;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get screen
     *
     * @return string|string[]|WP_Screen
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * Set screen
     *
     * @param string|string[]|WP_Screen $screen
     *
     * @return self
     */
    public function setScreen($screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     * Get context
     *
     * @return string
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * Set context
     *
     * @param string $context
     *
     * @return self
     */
    public function setContext(?string $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    /**
     * Set priority
     *
     * @param string $priority
     *
     * @return self
     */
    public function setPriority(?string $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get args
     *
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * Set args
     *
     * @param array $args
     *
     * @return self
     */
    public function setArgs(?array $args)
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Get layout
     *
     * @return MetaboxLayoutInterface
     */
    public function getLayout(): MetaboxLayoutInterface
    {
        return $this->layout;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->layout->renderComponent($request);
    }
}
