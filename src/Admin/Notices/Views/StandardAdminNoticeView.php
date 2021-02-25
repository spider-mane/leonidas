<?php

namespace WebTheory\Leonidas\Admin\Notices\Views;

use WebTheory\Html\Traits\ElementConstructorTrait;
use WebTheory\Leonidas\Admin\Contracts\ViewInterface;

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
            'class' => ['notice', "notice-{$type}", $isDismissible ? 'is-dismissible' : null]
        ];

        $noticeBody = $this->tag('p', [], htmlspecialchars($message));

        return $this->tag('div', $noticeAttr, $noticeBody);
    }
}
