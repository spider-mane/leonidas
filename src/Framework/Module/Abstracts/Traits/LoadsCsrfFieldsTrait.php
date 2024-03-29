<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;

trait LoadsCsrfFieldsTrait
{
    protected function renderCsrfFields(): string
    {
        $html = '';
        $repository = $this->getManagerRepository();

        foreach ($this->getRequiredManagerTags() as $manager) {
            $manager = $repository->get($manager);

            $html .= $manager->renderField() . "\n";
        }

        return $html;
    }

    abstract protected function getManagerRepository(): CsrfManagerRepositoryInterface;

    /**
     * Define by tag which csrf managers to load
     *
     * @return string[]
     */
    abstract protected function getRequiredManagerTags(): array;
}
