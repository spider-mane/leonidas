<?php

namespace Leonidas\Library\System\Model\Abstracts\Term;

use Leonidas\Contracts\System\Schema\Term\TermEntityManagerInterface;

abstract class AbstractTermEntityRepository
{
    protected TermEntityManagerInterface $manager;

    public function __construct(TermEntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function delete(int $pageId): void
    {
        $this->manager->delete($pageId);
    }
}
