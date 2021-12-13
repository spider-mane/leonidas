<?php

namespace Leonidas\Library\Admin\Notice\Views;

use Leonidas\Contracts\Ui\ViewInterface;
use WebTheory\Html\Traits\ElementConstructorTrait;

class StandardAdminNoticeView implements ViewInterface
{
    use ElementConstructorTrait;

    /**
     *
     */
    public function render(array $context): string
    {
        $type = $context['type'];
        $message = $context['message'];
        $isDismissible = $context['is_dismissible'];

        $noticeAttr = [
            'class' => ['notice', "notice-{$type}", $isDismissible ? 'is-dismissible' : null],
        ];

        $noticeBody = $this->tag('p', [], htmlspecialchars($message));

        return $this->tag('div', $noticeAttr, $noticeBody);
    }
}
