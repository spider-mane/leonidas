<?php

namespace Leonidas\Library\System;

use Leonidas\Contracts\System\BaseSystemModelTypeBuilderInterface;

abstract class AbstractSystemModelTypeBuilder implements BaseSystemModelTypeBuilderInterface
{
    protected string $name;

    protected string $pluralLabel;

    protected ?string $singularLabel;

    protected ?string $description;

    protected ?array $labels;

    protected ?bool $isPublic;

    protected ?bool $isHierarchical;

    protected ?bool $isPubliclyQueryable;

    protected ?bool $isShownInUi;

    /**
     * @var null|bool|string
     */
    protected $shownInMenus;

    protected ?bool $isShownInNavMenus;

    protected array $capabilities;

    /**
     * @var null|bool|array
     */
    protected $rewrite;

    /**
     * @var null|bool|string
     */
    protected $queryVar;

    protected ?bool $isShownInRest;

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
