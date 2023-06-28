<?php

namespace Leonidas\Library\System\Configuration\Abstracts;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeBuilderInterface;

abstract class AbstractSystemModelTypeBuilder implements BaseSystemModelTypeBuilderInterface
{
    protected string $name;

    protected string $pluralLabel;

    protected ?string $singularLabel;

    protected ?string $description;

    protected ?array $labels;

    protected ?bool $isPublic;

    protected ?bool $hierarchical;

    protected ?bool $publiclyQueryable;

    protected ?bool $isAllowedInUi;

    /**
     * @var null|bool|string
     */
    protected $displayedInMenu;

    protected ?bool $isAllowedInNavMenus;

    protected array $capabilities;

    /**
     * @var null|bool|array
     */
    protected $rewrite;

    /**
     * @var null|bool|string
     */
    protected $queryVar;

    protected ?bool $isAllowedInRest;

    /**
     * @var null|bool|string
     */
    protected $restBase;

    /**
     * @var null|bool|string
     */
    protected $restNamespace;

    /**
     * @var null|bool|string
     */
    protected $restControllerClass;

    protected ?array $options;

    public function __construct(?string $name = null)
    {
        $name && $this->name = $name;
    }
}
