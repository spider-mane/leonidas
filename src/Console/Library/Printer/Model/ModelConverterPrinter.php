<?php

namespace Leonidas\Console\Library\Printer\Model;

use Leonidas\Console\Library\Printer\Model\Abstracts\AbstractClassPrinter;
use Leonidas\Contracts\System\Schema\Comment\CommentConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use Leonidas\Contracts\System\Schema\User\UserConverterInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelConverter;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use Nette\PhpGenerator\PhpNamespace;
use WP_Comment;
use WP_Post;
use WP_Term;
use WP_User;

class ModelConverterPrinter extends AbstractClassPrinter
{
    public const TEMPLATES = [
        'post' => WP_Post::class,
        'post:h' => WP_Post::class,
        'attachment' => WP_Post::class,
        'term' => WP_Term::class,
        'term:h' => WP_Term::class,
        'user' => WP_User::class,
        'comment' => WP_Comment::class,
    ];

    public const CORES = [
        'post' => 'post',
        'post:h' => 'post',
        'attachment' => 'post',
        'term' => 'term',
        'term:h' => 'term',
        'user' => 'user',
        'comment' => 'comment',
    ];

    public const CONVERTERS = [
        'post' => PostConverterInterface::class,
        'post:h' => PostConverterInterface::class,
        'attachment' => PostConverterInterface::class,
        'term' => TermConverterInterface::class,
        'term:h' => TermConverterInterface::class,
        'user' => UserConverterInterface::class,
        'comment' => CommentConverterInterface::class,
    ];

    public const FUNCTIONS = [
        'post' => 'get_post(%s)',
        'post:h' => 'get_post(%s)',
        'attachment' => 'get_post(%s)',
        'term' => 'get_term(%s)',
        'term:h' => 'get_term(%s)',
        'user' => 'get_user_by(\'id\', %s)',
        'comment' => 'get_comment(%s)',
    ];

    protected string $model;

    protected string $contract;

    protected string $template;

    public function __construct(string $namespace, string $class, string $model, string $contract, string $template)
    {
        parent::__construct($namespace, $class);

        $this->model = $model;
        $this->contract = $contract;
        $this->template = $template;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $base = AbstractModelConverter::class;
        $error = UnexpectedEntityException::class;
        $converter = static::CONVERTERS[$this->template];
        $template = static::TEMPLATES[$this->template];
        $core = static::CORES[$this->template];
        $function = static::FUNCTIONS[$this->template];

        $class = $namespace
            ->addUse($base)
            ->addUse($error)
            ->addUse($converter)
            ->addUse($template)
            ->addUse($this->contract)
            ->addClass($this->class)
            ->setExtends($base)
            ->addImplement($converter);

        $model = explode('\\', $this->model);
        $model = end($model);

        $class->addMethod('convert')
            ->setPublic()
            ->setReturnType($this->contract)
            ->addBody(sprintf(
                'return new %s($%s, $this->autoInvoker);',
                $model,
                $core
            ))
            ->addParameter($core)
            ->setType($template);

        $contract = explode('\\', $this->contract);
        $contract = end($contract);

        $throw = explode('\\', $error);
        $throw = end($throw);

        $call = sprintf($function, '$' . $core . '->getId()');

        $class->addMethod('revert')
            ->setPublic()
            ->setReturnType($template)
            ->addBody(sprintf('if ($%s instanceof %s) {', $core, $contract))
            ->addBody(sprintf('    return %s;', $call))
            ->addBody("} \n")
            ->addBody(sprintf('throw new %s(', $throw))
            ->addBody(sprintf('    %s::class,', $contract))
            ->addBody(sprintf('    $%s,', $core))
            ->addBody('    __METHOD__')
            ->addBody(');')
            ->addParameter($core)
            ->setType('object');

        return $class;
    }
}
