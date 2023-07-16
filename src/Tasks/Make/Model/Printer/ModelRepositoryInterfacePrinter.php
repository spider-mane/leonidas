<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;
use Leonidas\Contracts\System\Model\SoftDeletingRepositoryInterface;
use Leonidas\Tasks\Make\Model\Printer\Abstracts\AbstractModelRepositoryPrinter;
use Nette\PhpGenerator\PhpNamespace;

class ModelRepositoryInterfacePrinter extends AbstractModelRepositoryPrinter
{
    protected function setupClass(PhpNamespace $namespace): object
    {
        $interface = $namespace
            ->addUse($this->model)
            ->addUse($this->collection)
            ->addInterface($this->class);

        switch ($this->template) {
            case 'post':
            case 'post:h':
            case 'attachment':
                $base = SoftDeletingRepositoryInterface::class;

                break;

            case 'term':
            case 'term:h':
            case 'user':
            case 'comment':
            default:
                $base = FungibleRepositoryInterface::class;
        }

        $namespace->addUse($base);
        $interface->setExtends($base);

        return $interface;
    }
}
