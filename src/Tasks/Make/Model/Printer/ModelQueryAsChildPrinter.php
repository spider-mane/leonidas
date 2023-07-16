<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Contracts\System\Schema\Comment\CommentConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use Leonidas\Contracts\System\Schema\User\UserConverterInterface;
use Leonidas\Library\System\Model\Abstracts\Post\PoweredByModelQueryKernelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Abstracts\Term\ValidatesTaxonomyTrait;
use Leonidas\Library\System\Model\Abstracts\User\ValidatesRoleTrait;
use Leonidas\Tasks\Make\Abstracts\AbstractClassPrinter;
use Nette\PhpGenerator\PhpNamespace;
use WP_Comment_Query;
use WP_Query;
use WP_Term_Query;
use WP_User_Query;

class ModelQueryAsChildPrinter extends AbstractClassPrinter
{
    public const CORE = 'kernel';

    public const QUERIES = [
        'post' => WP_Query::class,
        'post:h' => WP_Query::class,
        'attachment' => WP_Query::class,
        // 'term' => WP_Term_Query::class,
        // 'term:h' => WP_Term_Query::class,
        // 'user' => WP_User_Query::class,
        // 'comment' => WP_Comment_Query::class,
    ];

    public const ENGINES = [
        'post' => PoweredByModelQueryKernelTrait::class,
        'post:h' => PoweredByModelQueryKernelTrait::class,
        'attachment' => PoweredByModelQueryKernelTrait::class,
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

    public const VALIDATORS = [
        'post' => ValidatesPostTypeTrait::class,
        'post:h' => ValidatesPostTypeTrait::class,
        'attachment' => ValidatesPostTypeTrait::class,
        // 'term' => ValidatesTaxonomyTrait::class,
        // 'term:h' => ValidatesTaxonomyTrait::class,
        // 'user' => ValidatesRoleTrait::class,
    ];

    public const ASSERTIONS = [
        'post' => '$this->assertPostTypeOnQuery($query, ?);',
        'post:h' => '$this->assertPostTypeOnQuery($query, ?);',
        'attachment' => '$this->assertPostTypeOnQuery($query, ?);',
        // 'term' => '$this->assertTaxonomyOnQuery($query, ?);',
        // 'term:h' => '$this->assertTaxonomyOnQuery($query, ?);',
        // 'user' => '$this->assertRoleOnQuery($query, ?);',
        // 'comment' => '$this->assertCommentTypeOnQuery($query, ?);',
    ];

    protected string $model;

    protected string $single;

    protected string $plural;

    protected string $type;

    protected string $parent;

    protected string $entity;

    protected string $template;

    public function __construct(
        string $parent,
        string $model,
        string $single,
        string $plural,
        string $namespace,
        string $class,
        string $type,
        string $entity,
        string $template = 'post'
    ) {
        parent::__construct($namespace, $class);

        $this->parent = $parent;
        $this->model = $model;
        $this->single = $single;
        $this->plural = $plural;
        $this->type = $type;
        $this->entity = $entity;
        $this->template = $template;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $engine = static::ENGINES[$this->template];
        $converter = static::CONVERTERS[$this->template];
        $query = static::QUERIES[$this->template];
        $validator = static::VALIDATORS[$this->template];
        $assertion = static::ASSERTIONS[$this->template];

        $namespace
            ->addUse($this->type)
            ->addUse($this->parent)
            ->addUse($validator)
            ->addUse($engine)
            ->addUse($converter)
            ->addUse($query);

        $class = $namespace->addClass($this->class)
            ->setExtends($this->parent)
            ->addImplement($this->type);

        $class->addTrait($validator);
        $class->addTrait($engine);

        $constructor = $class->addMethod('__construct');
        $constraint = $this->template === 'attachment' ? 'attachment' : $this->entity;

        $constructor->addParameter('query')->setType($query);
        $constructor->addParameter('converter')->setType($converter);
        $constructor->addBody($assertion, [$constraint]);
        $constructor->addBody('$this->initKernel($query, $converter);');

        return $class;
    }
}
