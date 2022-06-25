<?php

namespace Leonidas\Console\Library;

use Leonidas\Console\Library\Abstracts\AbstractClassPrinter;
use Leonidas\Contracts\System\Schema\Comment\CommentConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use Leonidas\Contracts\System\Schema\User\UserConverterInterface;
use Nette\PhpGenerator\PhpNamespace;
use WP_Comment_Query;
use WP_Query;
use WP_Term_Query;
use WP_User_Query;

class ModelQueryFactoryPrinter extends AbstractClassPrinter
{
    public const QUERIES = [
        'post' => WP_Query::class,
        'post:h' => WP_Query::class,
        'attachment' => WP_Query::class,
        // 'term' => WP_Term_Query::class,
        // 'term:h' => WP_Term_Query::class,
        // 'user' => WP_User_Query::class,
        // 'comment' => WP_Comment_Query::class,
    ];

    public const CONVERTERS = [
        'post' => PostConverterInterface::class,
        'post:h' => PostConverterInterface::class,
        'attachment' => PostConverterInterface::class,
        // 'term' => TermConverterInterface::class,
        // 'term:h' => TermConverterInterface::class,
        // 'user' => UserConverterInterface::class,
        // 'comment' => CommentConverterInterface::class,
    ];

    protected string $query;

    protected string $template;

    public function __construct(string $namespace, string $class, string $query, string $template)
    {
        parent::__construct($namespace, $class);
        $this->query = $query;
        $this->template = $template;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $base = QueryFactoryInterface::class;
        $query = static::QUERIES[$this->template];
        $converter = static::CONVERTERS[$this->template];
        $return = explode('\\', $this->query);
        $return = end($return);

        $class = $namespace
            ->addUse($base)
            ->addUse($converter)
            ->addUse($query)
            ->addClass($this->class);

        $class->addImplement($base);

        $class->addProperty('converter')->setProtected()->setType($converter);

        $class->addMethod('__construct')
            ->setPublic()
            ->addBody('$this->converter = $converter;')
            ->addParameter('converter')
            ->setType($converter);

        $class->addMethod('createQuery')
            ->setPublic()
            ->addBody(sprintf('return new %s($query, $this->converter);', $return))
            ->setReturnType($this->query)
            ->addParameter('query')
            ->setType($query);

        return $class;
    }
}
