<?php

namespace WebTheory\Leonidas\Admin\Notices;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Traits\ElementConstructorTrait;
use WebTheory\Leonidas\Admin\Contracts\AdminNoticeInterface;
use WebTheory\Leonidas\Admin\Loaders\AdminNoticeLoader;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;

class StandardAdminNotice implements AdminNoticeInterface
{
    use ElementConstructorTrait;
    use CanBeRestrictedTrait;

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
    public function render()
    {
        echo $this->renderComponent(ServerRequest::fromGlobals());
    }

    /**
     *
     */
    public function renderComponent(ServerRequestInterface $request): string
    {
        $noticeAttr = [
            'class' => ['notice', "notice-{$this->type}", $this->dismissible ? 'is-dismissible' : null]
        ];

        $noticeBody = $this->tag('p', [], htmlspecialchars($this->message));

        return $this->tag('div', $noticeAttr, $noticeBody);
    }
}
