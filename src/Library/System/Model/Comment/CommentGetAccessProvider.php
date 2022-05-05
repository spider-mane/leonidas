<?php

namespace Leonidas\Library\System\Model\Comment;

use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Schema\Comment\CommentEntityManagerInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class CommentGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(CommentInterface $comment)
    {
        parent::__construct($comment, $this->resolvedGetters($comment));
    }

    protected function resolvedGetters(CommentInterface $comment): array
    {
        $dateFormat = CommentEntityManagerInterface::DATE_FORMAT;

        $getDate = fn () => $comment->getDate()->format($dateFormat);
        $getDateGmt = fn () => $comment->getDateGmt()->format($dateFormat);

        return [
            'date' => $getDate,
            'dateGmt' => $getDateGmt,
            'date_gmt' => $getDateGmt,
        ];
    }
}
