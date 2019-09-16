<?php

namespace Backalley\Wordpress\Modules;

use Backalley\Html\Traits\ElementConstructorTrait;

class AdminNotice
{
    use ElementConstructorTrait;

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
    public function __construct(string $message)
    {
        $this->message = $message;
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
