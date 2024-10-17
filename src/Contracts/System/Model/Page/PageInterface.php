<?php

namespace Leonidas\Contracts\System\Model\Page;

use Leonidas\Contracts\System\Model\CommentableInterface;
use Leonidas\Contracts\System\Model\FilterableInterface;
use Leonidas\Contracts\System\Model\HierarchicalInterface;
use Leonidas\Contracts\System\Model\MimeInterface;
use Leonidas\Contracts\System\Model\MutableAuthoredInterface;
use Leonidas\Contracts\System\Model\MutableContentInterface;
use Leonidas\Contracts\System\Model\MutableDatableInterface;
use Leonidas\Contracts\System\Model\MutablePostModelInterface;
use Leonidas\Contracts\System\Model\MutableTitledInterface;
use Leonidas\Contracts\System\Model\Page\Status\PageStatusInterface;
use Leonidas\Contracts\System\Model\PingableInterface;
use Leonidas\Contracts\System\Model\RestrictableInterface;

interface PageInterface extends
    FilterableInterface,
    MutableAuthoredInterface,
    MutableContentInterface,
    MutablePostModelInterface,
    PingableInterface,
    CommentableInterface,
    RestrictableInterface,
    MimeInterface,
    MutableDatableInterface,
    HierarchicalInterface,
    MutableTitledInterface
{
    public function getParent(): ?PageInterface;

    public function setParent(?PageInterface $parent): self;

    public function getChildren(): PageCollectionInterface;

    public function getStatus(): PageStatusInterface;

    public function setStatus(PageStatusInterface $status): self;
}
