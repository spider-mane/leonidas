<?php

namespace Leonidas\Library\System\Configuration\Abstracts;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeBuilderInterface;

abstract class AbstractSystemModelTypeBuilder implements BaseSystemModelTypeBuilderInterface
{
    protected string $name;

    protected string $pluralLabel;

    protected ?string $singularLabel = null;

    protected ?string $description = null;

    protected ?array $labels = null;

    protected ?bool $isPublic = null;

    protected ?bool $hierarchical = null;

    protected ?bool $publiclyQueryable = null;

    protected ?bool $isAllowedInUi = null;

    /**
     * @var null|bool|string
     */
    protected $displayedInMenu;

    protected ?bool $isAllowedInNavMenus = null;

    protected array $capabilities;

    /**
     * @var null|bool|array
     */
    protected $rewrite;

    /**
     * @var null|bool|string
     */
    protected $queryVar;

    protected ?bool $isAllowedInRest = null;

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

    protected ?array $options = null;

    public function __construct(?string $name = null)
    {
        $name && $this->name = $name;
    }
}
