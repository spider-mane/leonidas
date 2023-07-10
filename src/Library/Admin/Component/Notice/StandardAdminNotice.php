<?php

namespace Leonidas\Library\Admin\Component\Notice;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Leonidas\Library\Admin\Component\Notice\View\StandardAdminNoticeView;
use Leonidas\Library\Core\Http\Policy\NoPolicy;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class StandardAdminNotice implements AdminNoticeInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    public function __construct(
        protected string $id,
        protected string $message,
        protected string $field,
        protected string $type = 'error',
        protected bool $isDismissible = true,
        ?ServerRequestPolicyInterface $policy = null
    ) {
        $this->policy = $policy ?? new NoPolicy();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function isDismissible(): bool
    {
        return $this->isDismissible;
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new StandardAdminNoticeView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'is_dismissible' => $this->isDismissible(),
            'message' => $this->getMessage(),
        ];
    }
}
