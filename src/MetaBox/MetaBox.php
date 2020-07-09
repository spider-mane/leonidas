<?php

namespace WebTheory\Leonidas\MetaBox;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Html\Html;
use WebTheory\Leonidas\MetaBox\Contracts\MetaboxContentInterface;
use WebTheory\Leonidas\Traits\HasNonceTrait;

class MetaBox
{
    use HasNonceTrait;

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
     * callback
     *
     * @var callable
     */
    protected $callback;

    /**
     * screen
     *
     * @var string
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
    protected $callbackArgs;

    /**
     * content
     *
     * @var MetaboxContentInterface[]
     */
    protected $content = [];

    /**
     * fields
     *
     * @var array
     */
    protected $fields = [];

    /**
     *
     */
    public function __construct(string $id, string $title, string $screen)
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
     * Get callback
     *
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * Set callback
     *
     * @param callable  $callback  callback
     *
     * @return self
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Get screen
     *
     * @return string|array
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
     * Get content
     *
     * @return  array
     */
    public function getContent($slug = null)
    {
        return isset($slug) ? $this->content[$slug] : $this->content;
    }

    /**
     *
     */
    public function addContent(string $slug, MetaboxContentInterface $content)
    {
        $this->content[$slug] = $content;

        return $this;
    }

    /**
     *
     */
    public function setContent(array $content)
    {
        foreach ($content as $name => $thing) {
            $this->addContent($name, $thing);
        }

        return $this;
    }

    /**
     *
     */
    public function hook()
    {
        add_action("add_meta_boxes_{$this->screen}", [$this, 'register']);

        if (!empty($this->save_cb)) {
            add_action("save_post_{$this->screen}", $this->save_cb, null, 3);
        }

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
            [$this, 'display'],
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
    public function display($post, $metaBox)
    {
        isset($this->callback) ? ($this->callback)($post, $metaBox, $this) : $this->render($post);
    }

    /**
     *
     */
    public function render($post)
    {
        $request = ServerRequest::fromGlobals()->withAttribute('post', $post);

        $html = '';
        $html .= $this->maybeRenderNonce();
        $html .= Html::open('div', ['class' => 'backalley-wrap']);

        $i = count($this->content);

        foreach ($this->content as $content) {
            $i--;

            if ($content->shouldBeRendered($request)) {

                $html .= $content->render($request);

                if ($i > 0) {
                    $html .= '<hr>';
                }
            }
        }

        $html .= Html::close('div');

        echo $html;
    }
}
