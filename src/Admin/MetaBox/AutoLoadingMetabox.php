<?php

namespace WebTheory\Leonidas\Admin\Metabox;

use GuzzleHttp\Psr7\ServerRequest;
use WP_Post;
use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;

class AutoLoadingMetabox
{
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
     * @var string
     */
    protected $context = 'normal';

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
    public function __construct(string $id, string $title, $screen)
    {
        $this->id = $id;
        $this->title = $title;
        $this->screen = $screen;
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
     *
     */
    public function hook()
    {
        add_action("add_meta_boxes_{$this->screen}", [$this, 'register']);

        return $this;
    }

    /**
     * Callback function to add metabox to admin ui
     *
     * @param $post
     */
    public function register()
    {
        add_meta_box(
            $this->id,
            $this->title,
            [$this, 'renderMetabox'],
            $this->screen,
            $this->context,
            $this->priority,
            $this->callbackArgs
        );

        return $this;
    }

    /**
     *
     */
    public function renderMetabox(WP_Post $post, array $args)
    {
        $request = ServerRequest::fromGlobals()
            ->withAttribute('post', $post)
            ->withAttribute('args', $args);

        echo $this->layout->renderComponent($request);
    }
}
