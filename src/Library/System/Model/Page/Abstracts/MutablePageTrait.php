<?php

namespace Leonidas\Library\System\Model\Page\Abstracts;

use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\Status\PageStatusInterface;

trait MutablePageTrait
{
    use PageTrait;

    public function setParent(?PageInterface $parent): self
    {
        $this->mirror('parent', $parent, 'post_parent', $parent ? $parent->getId() : 0);

        return $this;
    }

    public function setStatus(PageStatusInterface $status): self
    {
        $this->post->post_status = $status->getName();

        return $this;
    }
}
