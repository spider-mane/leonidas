<?php

namespace Leonidas\Library\Admin\Component\Notice\View;

use Leonidas\Contracts\Ui\ViewInterface;
use WebTheory\Html\Traits\ElementConstructorTrait;

class StandardAdminNoticeView implements ViewInterface
{
    use ElementConstructorTrait;

    public function render(array $data): string
    {
        $type = $data['type'];
        $message = $data['message'];
        $isDismissible = $data['is_dismissible'];

        $noticeAttr = [
            'class' => ['notice', "notice-{$type}", $isDismissible ? 'is-dismissible' : null],
        ];

        $noticeBody = $this->tag('p', [], htmlspecialchars($message));

        return $this->tag('div', $noticeAttr, $noticeBody) . "\n";
    }
}
