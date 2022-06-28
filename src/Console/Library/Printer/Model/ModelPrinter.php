<?php

namespace Leonidas\Console\Library\Printer\Model;

use Leonidas\Console\Library\Printer\Model\Abstracts\AbstractTypedClassPrinter;
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
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use Leonidas\Library\System\Model\Abstracts\Post\FilterablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\HierarchicalPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MimePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableAuthoredPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableCommentablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableContentPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableDatablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePingablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\RestrictablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Abstracts\Term\HierarchicalTermTrait;
use Leonidas\Library\System\Model\Abstracts\Term\MutableTermModelTrait;
use Leonidas\Library\System\Model\Abstracts\Term\ValidatesTaxonomyTrait;
use Leonidas\Library\System\Model\Abstracts\User\MutableUserModelTrait;
use Leonidas\Library\System\Model\Abstracts\User\ValidatesRoleTrait;
use Nette\PhpGenerator\PhpNamespace;
use WP_Comment;
use WP_Post;
use WP_Term;
use WP_User;

class ModelPrinter extends AbstractTypedClassPrinter
{
    public const TEMPLATES = [
        'post' => WP_Post::class,
        'post:h' => WP_Post::class,
        'attachment' => WP_Post::class,
        'term' => WP_Term::class,
        'term:h' => WP_Term::class,
        'user' => WP_User::class,
        // 'comment' => WP_Comment::class,
    ];

    public const CORES = [
        'post' => 'post',
        'post:h' => 'post',
        'attachment' => 'post',
        'term' => 'term',
        'term:h' => 'term',
        'user' => 'user',
        // 'comment' => 'comment',
    ];

    public const VALIDATORS = [
        'post' => ValidatesPostTypeTrait::class,
        'post:h' => ValidatesPostTypeTrait::class,
        'attachment' => ValidatesPostTypeTrait::class,
        'term' => ValidatesTaxonomyTrait::class,
        'user' => ValidatesRoleTrait::class,
    ];

    public const ASSERTIONS = [
        'post' => "\$this->assertPostType($%s, '%s');",
        'post:h' => "\$this->assertPostType($%s, '%s');",
        'attachment' => "\$this->assertPostType($%s, '%s');",
        'term' => "\$this->assertTaxonomy($%s, '%s');",
        'term:h' => "\$this->assertTaxonomy($%s, '%s');",
        'user' => "\$this->assertRole($%s, '%s');",
    ];

    public const PARTIALS = [
        'post' => [
            FilterableInterface::class => FilterablePostModelTrait::class,
            MutableAuthoredInterface::class => MutableAuthoredPostModelTrait::class,
            MutableContentInterface::class => MutableContentPostModelTrait::class,
            MutablePostModelInterface::class => MutablePostModelTrait::class,
            PingableInterface::class => MutablePingablePostModelTrait::class,
            CommentableInterface::class => MutableCommentablePostModelTrait::class,
            RestrictableInterface::class => RestrictablePostModelTrait::class,
            MimeInterface::class => MimePostModelTrait::class,
            MutableDatableInterface::class => MutableDatablePostModelTrait::class,
        ],
        'post:h' => [
            '@post',
            HierarchicalInterface::class => HierarchicalPostModelTrait::class,
        ],
        'attachment' => [
            '@post',
        ],
        'term' => [
            MutableTermModelInterface::class => MutableTermModelTrait::class,
        ],
        'term:h' => [
            '@term',
            HierarchicalInterface::class => HierarchicalTermTrait::class,
        ],
        'user' => [
            MutableUserModelInterface::class => MutableUserModelTrait::class,
        ],
        // 'comment' => [],
    ];

    protected string $entity;

    protected string $template;

    public function __construct(
        string $namespace,
        string $class,
        string $type,
        string $entity,
        string $template = 'post'
    ) {
        parent::__construct($namespace, $class, $type);

        $this->entity = $entity;
        $this->template = $template;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $accessTrait = AllAccessGrantedTrait::class;
        $lazyLoadTrait = LazyLoadableRelationshipsTrait::class;
        $invoker = AutoInvokerInterface::class;
        $template = static::TEMPLATES[$this->template];
        $core = static::CORES[$this->template];
        $validator = static::VALIDATORS[$this->template];
        $assertion = static::ASSERTIONS[$this->template];

        $class = $namespace
            ->addUse($this->type)
            ->addUse($accessTrait)
            ->addUse($lazyLoadTrait)
            ->addUse($validator)
            ->addUse($invoker)
            ->addUse($template)
            ->addClass($this->class);

        $class->addImplement($this->type);
        $class->addTrait($accessTrait);
        $class->addTrait($lazyLoadTrait);
        $class->addTrait($validator);

        foreach ($this->getResolvedPartials() as $partial) {
            $namespace->addUse($partial);
            $class->addTrait($partial);
        }

        $constructor = $class->addMethod('__construct')->setPublic();
        $constraint = $this->template === 'attachment' ? 'attachment' : $this->entity;

        $constructor->addParameter($core)->setType($template);
        $constructor->addParameter('autoInvoker')->setType($invoker);

        $constructor->addBody(sprintf($assertion, $core, $constraint) . "\n");
        $constructor->addBody(sprintf('$this->%s = $%s;', $core, $core));
        $constructor->addBody('$this->autoInvoker = $autoInvoker;' . "\n");

        $getAccessTemplate = $this->isPostTemplate()
            ? '$this->getAccessProvider = new %sTagAccessProvider($this, $%s);'
            : '$this->getAccessProvider = new %sGetAccessProvider($this);';

        $constructor->addBody(sprintf($getAccessTemplate, $this->class, $core));
        $constructor->addBody(sprintf(
            '$this->setAccessProvider = new %sSetAccessProvider($this);',
            $this->class
        ));

        return $class;
    }

    protected function isPostTemplate(): bool
    {
        return in_array($this->template, ['post', 'post:h', 'attachment']);
    }

    protected function getResolvedPartials(): array
    {
        $partials = [];
        $map = [];

        foreach (static::PARTIALS[$this->template] as $contract => $partial) {
            if (str_starts_with($partial, '@')) {
                $inherit = static::PARTIALS[substr($partial, 1)];

                $partials = [...array_values($inherit), ...$partials];
                $map = $map + array_flip($inherit);
            } else {
                $partials[] = $partial;
                $map[$partial] = $contract;
            }
        }

        return $this->isDoingTypeMatch()
            ? $this->matchTraitsToType($partials, $map)
            : $partials;
    }
}
