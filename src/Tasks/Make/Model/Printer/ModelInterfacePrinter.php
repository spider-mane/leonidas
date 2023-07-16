<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Contracts\System\Model\CommentableInterface;
use Leonidas\Contracts\System\Model\FilterableInterface;
use Leonidas\Contracts\System\Model\HierarchicalInterface;
use Leonidas\Contracts\System\Model\MimeInterface;
use Leonidas\Contracts\System\Model\MutableAuthoredInterface;
use Leonidas\Contracts\System\Model\MutableContentInterface;
use Leonidas\Contracts\System\Model\MutableDatableInterface;
use Leonidas\Contracts\System\Model\MutablePostModelInterface;
use Leonidas\Contracts\System\Model\MutableTermModelInterface;
use Leonidas\Contracts\System\Model\MutableUserModelInterface;
use Leonidas\Contracts\System\Model\PingableInterface;
use Leonidas\Contracts\System\Model\RestrictableInterface;
use Leonidas\Tasks\Make\Abstracts\AbstractClassPrinter;
use Nette\PhpGenerator\PhpNamespace;
use Stringable;

class ModelInterfacePrinter extends AbstractClassPrinter
{
    protected const PARTIALS = [
        'post' => [
            FilterableInterface::class,
            MutableAuthoredInterface::class,
            MutableContentInterface::class,
            MutablePostModelInterface::class,
            PingableInterface::class,
            CommentableInterface::class,
            RestrictableInterface::class,
            MimeInterface::class,
            MutableDatableInterface::class,
        ],
        'post:h' => [
            '@post',
            HierarchicalInterface::class,
        ],
        'attachment' => [
            '@post',
        ],
        'term' => [
            MutableTermModelInterface::class,
        ],
        'term:h' => [
            '@term',
            HierarchicalInterface::class,
        ],
        'user' => [
            MutableUserModelInterface::class,
        ],
        'comment' => [
            HierarchicalInterface::class,
            Stringable::class,
        ],
    ];

    protected string $template;

    public function __construct(string $namespace, string $class, string $template = 'post')
    {
        parent::__construct($namespace, $class);

        $this->template = $template;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $interface = $namespace->addInterface($this->class);

        foreach ($this->getResolvedPartials() as $partial) {
            $namespace->addUse($partial);
            $interface->addExtend($partial);
        }

        return $interface;
    }

    protected function getResolvedPartials(): array
    {
        $partials = [];

        foreach (static::PARTIALS[$this->template] as $partial) {
            if (str_starts_with($partial, '@')) {
                $inherit = static::PARTIALS[substr($partial, 1)];

                $partials = [...array_values($inherit), ...$partials];
            } else {
                $partials[] = $partial;
            }
        }

        return $partials;
    }
}
