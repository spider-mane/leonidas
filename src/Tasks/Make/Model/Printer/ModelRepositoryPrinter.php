<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Library\System\Model\Abstracts\Attachment\AbstractAttachmentEntityRepository;
use Leonidas\Library\System\Model\Abstracts\Comment\AbstractCommentModelRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\Post\AbstractPostEntityRepository;
use Leonidas\Library\System\Model\Abstracts\Term\AbstractTermEntityRepository;
use Leonidas\Library\System\Model\Abstracts\User\AbstractUserModelRepository;
use Leonidas\Tasks\Make\Abstracts\TypedClassPrinterTrait;
use Leonidas\Tasks\Make\Model\Printer\Abstracts\AbstractModelRepositoryPrinter;
use Nette\PhpGenerator\PhpNamespace;

class ModelRepositoryPrinter extends AbstractModelRepositoryPrinter
{
    use TypedClassPrinterTrait;

    public const ABSTRACTS = [
        'post' => AbstractPostEntityRepository::class,
        'post:h' => AbstractPostEntityRepository::class,
        'attachment' => AbstractAttachmentEntityRepository::class,
        'term' => AbstractTermEntityRepository::class,
        'term:h' => AbstractTermEntityRepository::class,
        'user' => AbstractUserModelRepository::class,
        'comment' => AbstractCommentModelRepositoryInterface::class,
    ];

    protected string $template;

    public function __construct(
        string $model,
        string $collection,
        string $single,
        string $plural,
        string $namespace,
        string $class,
        string $type,
        string $template = 'post'
    ) {
        parent::__construct(
            $model,
            $collection,
            $single,
            $plural,
            $namespace,
            $class,
            $template
        );

        $this->type = $type;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        return $namespace
            ->addUse($this->model)
            ->addUse($this->collection)
            ->addUse($this->type)
            ->addUse($parent = static::ABSTRACTS[$this->template])
            ->addClass($this->class)
            ->setExtends($parent)
            ->addImplement($this->type);
    }

    protected function finishClass($class): void
    {
        $data = $class->addMethod('extractData')
            ->setVisibility('protected')
            ->setReturnType('array')
            ->setBody('return [];');

        $data->addParameter($this->single)->setType($this->model);

        if (in_array($this->template, ['post', 'attachment'])) {
            $tax = $class->addMethod('extractTaxInput')
                ->setVisibility('protected')
                ->setReturnType('array')
                ->setBody('return [];');

            $tax->addParameter($this->single)->setType($this->model);
        }

        $meta = $class->addMethod('extractMetaInput')
            ->setVisibility('protected')
            ->setReturnType('array')
            ->setBody('return [];');

        $meta->addParameter($this->single)->setType($this->model);
    }
}
