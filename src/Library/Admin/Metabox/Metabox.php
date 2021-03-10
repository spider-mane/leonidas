<?php

namespace Leonidas\Library\Admin\Metabox;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use WP_Post;
use Leonidas\Contracts\Admin\Components\MetaboxInterface;
use Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use Leonidas\Traits\CanBeRestrictedTrait;
use Leonidas\Traits\RendersWithViewTrait;

class Metabox implements MetaboxInterface
{
    use CanBeRestrictedTrait;

    /**
     * id
     *
     * @var string
     */
    protected $id;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * screen
     *
     * @var string|string[]|WP_Screen
     */
    protected $screen;

    /**
     * context
     *
     * @var null|string
     */
    protected $context = 'advanced';

    /**
     * priority
     *
     * @var string
     */
    protected $priority = 'default';

    /**
     * callbackArgs
     *
     * @var array
     */
    protected $callbackArgs = [];

    /**
     * layout
     *
     * @var MetaboxLayoutInterface
     */
    protected $layout;

    /**
     *
     */
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
     * @param string|string[]|WP_Screen $screen screen
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
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Set context
     *
     * @param string  $context  context
     *
     * @return self
     */
    public function setContext(string $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * Set priority
     *
     * @param string  $priority  priority
     *
     * @return self
     */
    public function setPriority(string $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get callbackArgs
     *
     * @return array
     */
    public function getCallbackArgs(): array
    {
        return $this->callbackArgs;
    }

    /**
     * Set callbackArgs
     *
     * @param array  $callbackArgs  callbackArgs
     *
     * @return self
     */
    public function setCallbackArgs(array $callbackArgs)
    {
        $this->callbackArgs = $callbackArgs;

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
