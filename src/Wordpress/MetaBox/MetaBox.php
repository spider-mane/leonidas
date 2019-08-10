<?php

namespace Backalley\WordPress\MetaBox;

use Backalley\Html\Html;
use Backalley\FormFields\Input;
use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;

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
        add_action("add_meta_boxes_{$this->screen}", [$this, '_addMetaBox']);

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
    public function _addMetaBox($post)
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
        echo $this->generateNonceField();

        $mb = '';
        $count = $i = count($this->content);

        echo '<div>';

        foreach ($this->content as $content) {
            $i--;

            $content->render($post);

            if ($i > 0) {
                echo '<hr>';
            }
        }

        echo '</div>';
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
        $this->nonce['name'] = password_hash($this->id, PASSWORD_BCRYPT);
        $this->nonce['action'] = password_hash($this->title, PASSWORD_BCRYPT);

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

        $nonce .= (new Input) // nonce
            ->setType('hidden')
            ->setName($this->nonce['name'])
            ->setValue(wp_create_nonce($this->nonce['action']));

        $nonce .= (new Input) // referer
            ->setType('hidden')
            ->setName('_backalley_http_referer')
            ->setValue(esc_attr(wp_unslash($_SERVER['REQUEST_URI'])));

        // return wp_nonce_field($this->nonce['action'], $this->nonce['name'], true, false);

        return (string) $nonce . "\n";
    }
}
