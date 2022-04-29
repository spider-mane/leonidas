<?php

namespace Leonidas\Library\System\Model\Page\Status;

use Leonidas\Contracts\System\Model\Page\Status\PageStatusInterface;

class PageStatus implements PageStatusInterface
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
