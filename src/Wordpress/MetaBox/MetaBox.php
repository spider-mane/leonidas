<?php

namespace WebTheory\WordPress\MetaBox;

use WebTheory\Form\Fields\Hidden as HiddenInput;
use WebTheory\Html\Html;
use WebTheory\WordPress\MetaBox\Contracts\MetaboxContentInterface;

/**
 * @package Backalley-Core
 */
class MetaBox
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
     * callback
     *
     * @var callable
     */
    protected $callback;

    /**
     * screen
     *
     * @var string|array
     */
    protected $screen;

    /**
     * context
     *
     * @var string
     */
    protected $context;

    /**
     * priority
     *
     * @var string
     */
    protected $priority;

    /**
     * callbackArgs
     *
     * @var array
     */
    protected $callbackArgs;

    /**
     * content
     *
     * @var array
     */
    protected $content = [];

    /**
     * fields
     *
     * @var array
     */
    protected $fields = [];

    /**
     * @var string
     */
    private $nonce;

    /**
     *
     */
    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->setNonce();
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
     * Set screen
     *
     * @param string|array  $screen  screen
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
        $screen = isset($this->screen) ? "add_meta_boxes_{$this->screen}" : null;

        add_action($screen, [$this, 'register']);

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
        add_meta_box($this->id, $this->title, [$this, 'display'], $this->screen, $this->context, $this->priority, $this->callbackArgs);
    }

    /**
     *
     */
    public function display($post, $metaBox)
    {
        if (!isset($this->callback)) {
            $this->render($post);
        } else {
            $callback = $this->callback;
            $callback($post, $metaBox, $this);
        }
    }

    /**
     *
     */
    protected function render($post)
    {
        $html = '';
        $html .= $this->generateNonceField();
        $i = count($this->content);

        $html .= Html::open('div', ['class' => 'backalley-wrap']);

        foreach ($this->content as $content) {
            $i--;

            $html .= $content->render($post);

            if ($i > 0) {
                $html .= '<hr>';
            }
        }

        $html .= Html::close('div');

        echo $html;
    }

    /**
     * Get the value of nonce
     *
     * @return string
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * Set the value of nonce
     *
     * @return self
     */
    private function setNonce()
    {
        $this->nonce['name'] = md5($this->id);
        $this->nonce['action'] = md5($this->title);

        return $this;
    }

    /**
     * Set the value of nonce
     *
     * @param string $nonce
     *
     * @return self
     */
    public function generateNonceField()
    {
        $nonce = '';

        $nonce .= (new HiddenInput) // nonce
            ->setName($this->nonce['name'])
            ->setValue(wp_create_nonce($this->nonce['action']))
            ->toHtml();

        $nonce .= (new HiddenInput) // referer
            ->setName('_backalley_http_referer')
            ->setValue(esc_attr(wp_unslash($_SERVER['REQUEST_URI'])))
            ->toHtml();

        return (string) $nonce . "\n";
    }
}
