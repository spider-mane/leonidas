<?php

namespace Leonidas\Library\Admin\Component\Page\Traits;

use Leonidas\Contracts\Admin\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\SubmenuFileResolverInterface;
use Psr\Http\Message\ServerRequestInterface;

trait NestedPageTrait
{
    protected string $parentSlug;

    protected ?ParentFileResolverInterface $parentFileResolver;

    protected ?SubmenuFileResolverInterface $submenuFileResolver;

    public function __construct(
        string $parentSlug,
        ?ParentFileResolverInterface $parentFileResolver = null,
        ?SubmenuFileResolverInterface $subMenuFileResolver = null
    ) {
        $this->parentSlug = $parentSlug;
        $this->parentFileResolver = $parentFileResolver;
        $this->submenuFileResolver = $subMenuFileResolver;
    }

    public function getParentSlug(): string
    {
        return $this->parentSlug;
    }

    public function getSubmenuFileResolver(): ?SubmenuFileResolverInterface
    {
        return $this->submenuFileResolver;
    }

    public function getParentFileResolver(): ?ParentFileResolverInterface
    {
        return $this->parentFileResolver;
    }

    public function defineSubmenuFile(ServerRequestInterface $request): string
    {
        return ($resolver = $this->getSubmenuFileResolver())
            ? $resolver->resolveSubmenuFile($request)
            : null;
    }

    public function defineParentFile(ServerRequestInterface $request): string
    {
        return ($resolver = $this->getParentFileResolver())
            ? $resolver->resolveParentFile($request)
            : null;
    }
}
