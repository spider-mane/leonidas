<?php

namespace WebTheory\Leonidas\Modules;

use WebTheory\Html\Traits\ElementConstructorTrait;

class AdminNotice
{
    use ElementConstructorTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var bool
     */
    protected $dismissible = true;

    /**
     * @var string
     */
    protected $type = 'error';

    /**
     * @var string
     */
    protected $screen;

    /**
     * @var string
     */
    public function __construct(string $message, string $id = '')
    {
        $this->id = $id;
        $this->message = $message;
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of dismissible
     *
     * @return bool
     */
    public function isDismissible(): bool
    {
        return $this->dismissible;
    }

    /**
     * Set the value of dismissible
     *
     * @param bool $dismissible
     *
     * @return self
     */
    public function setDismissible(bool $dismissible)
    {
        $this->dismissible = $dismissible;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of screen
     *
     * @return string
     */
    public function getScreen(): string
    {
        return $this->screen;
    }

    /**
     * Set the value of screen
     *
     * @param string $screen
     *
     * @return self
     */
    public function setScreen(string $screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     *
     */
    public function register()
    {
        AdminNoticeLoader::addNotice($this);
    }

    /**
     *
     */
    public function hook()
    {
        add_action('admin_notices', [$this, 'render']);
    }

    /**
     *
     */
    public function toHtml()
    {
        $noticeAttr = [
            'class' => ['notice', "notice-{$this->type}", $this->dismissible ? 'is-dismissible' : null]
        ];

        return $this->tag('div', $this->tag('p', htmlspecialchars($this->message)), $noticeAttr);
    }

    /**
     *
     */
    public function render()
    {
        echo $this->toHtml();
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
