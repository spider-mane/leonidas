<?php

namespace Leonidas\Library\Admin\Component\Notice;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Leonidas\Library\Admin\Component\Notice\View\StandardAdminNoticeView;
use Psr\Http\Message\ServerRequestInterface;

class StandardAdminNotice implements AdminNoticeInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    protected string $id;

    protected string $message;

    protected bool $dismissible = true;

    /**
     * @var string
     */
    protected $type = 'error';

    protected ?string $screen = null;

    /**
     * @var null|int|int[]
     */
    protected $users;

    protected ?string $field = null;

    /**
     *
     * @param string $message
     * @param string $id
     */
    public function __construct(string $message, string $id = '', ?int $users = null)
    {
        $this->id = $id;
        $this->message = $message;
        $this->users = $users;
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
     * @return $this
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setScreen(string $screen)
    {
        $this->screen = $screen;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new StandardAdminNoticeView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'type' => $this->type,
            'is_dismissible' => $this->dismissible,
            'message' => $this->message,
        ];
    }
}
