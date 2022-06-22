<?php

namespace Leonidas\Console\Library;

use Leonidas\Console\Library\Abstracts\AbstractClassPrinter;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Library\System\Model\Abstracts\Post\UsesTemplateTagsTrait;
use Nette\PhpGenerator\PhpNamespace;
use WP_Comment;
use WP_Post;
use WP_Term;
use WP_User;

class ModelTemplateTagsProviderPrinter extends AbstractClassPrinter
{
    public const TEMPLATES = [
        'post' => WP_Post::class,
        'post:h' => WP_Post::class,
        'attachment' => WP_Post::class,
        // 'term' => WP_Term::class,
        // 'term:h' => WP_Term::class,
        // 'user' => WP_User::class,
        // 'comment' => WP_Comment::class,
    ];

    public const TAG_TRAITS = [
        'post' => UsesTemplateTagsTrait::class,
        'post:h' => UsesTemplateTagsTrait::class,
        'attachment' => UsesTemplateTagsTrait::class,
    ];

    protected string $model;

    protected string $single;

    protected string $base;

    protected string $template;

    public function __construct(
        string $namespace,
        string $class,
        string $model,
        string $single,
        string $base,
        string $template = 'post'
    ) {
        parent::__construct($namespace, $class);

        $this->model = $model;
        $this->single = $single;
        $this->base = $base;
        $this->template = $template;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $contract = GetAccessProviderInterface::class;
        $tagTrait = static::TAG_TRAITS[$this->template];
        $template = static::TEMPLATES[$this->template];

        $class = $namespace
            ->addUse($this->base)
            ->addUse($this->model)
            ->addUse($template)
            ->addUse($contract)
            ->addUse($tagTrait)
            ->addClass($this->class);

        $class->setExtends($this->base);
        $class->addImplement($contract);
        $class->addTrait($tagTrait);

        $construct = $class->addMethod('__construct')
            ->setPublic()
            ->addBody(sprintf('parent::__construct($%s);', $this->single))
            ->addBody('$this->stashPostObject($core);');

        $construct->addParameter($this->single)->setType($this->model);
        $construct->addParameter('core')->setType($template);

        $class->addMethod('resolvedGetters')
            ->setPublic()
            ->setReturnType('array')
            ->setBody($this->getResolvedGettersMethodBody())
            ->addParameter($this->single)
            ->setType($this->model);

        return $class;
    }

    protected function getResolvedGettersMethodBody(): string
    {
        $body = 'return [' . "\n";
        $body .= '    \'id\' => $this->templateTag(\'the_ID\'),' . "\n";
        $body .= '] + parent::resolvedGetters($%s);';

        return sprintf($body, $this->single);
    }
}
