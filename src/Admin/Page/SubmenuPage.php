<?php

namespace WebTheory\Leonidas\Admin\Page;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLoadErrorInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminTitleResolverInterface;
use WebTheory\Leonidas\Admin\Contracts\ParentFileResolverInterface;
use WebTheory\Leonidas\Admin\Contracts\SubmenuFileResolverInterface;
use WebTheory\Leonidas\Admin\Contracts\SubmenuPageInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;

class SubmenuPage extends AbstractAdminPage implements SubmenuPageInterface
{
    use CanBeRestrictedTrait;

    /**
     * @var null|string
     */
    protected $parentSlug;

    /**
     * @see https://developer.wordpress.org/reference/hooks/submenu_file/
     *
     * @var null|SubmenuFileResolverInterface
     */
    protected $submenuFileResolver;

    /**
     * @see https://developer.wordpress.org/reference/hooks/parent_file/
     *
     * @var null|ParentFileResolverInterface
     */
    protected $parentFileResolver;

    /**
     * Get parent_slug
     *
     * @return  string
     */
    public function getParentSlug()
    {
        return $this->parentSlug;
    }

    /**
     * Set parent_slug
     *
     * @param   string  $parent_slug  parent_slug
     *
     * @return  self
     */
    public function SetParentSlug(string $parentSlug): SubmenuPage
    {
        $this->parentSlug = $parentSlug;

        return $this;
    }

    /**
     * Get the value of submenuFileResolver
     *
     * @return null|SubmenuFileResolverInterface
     */
    public function getSubmenuFileResolver(): ?SubmenuFileResolverInterface
    {
        return $this->submenuFileResolver;
    }

    /**
     * Set the value of submenuFileResolver
     *
     * @param SubmenuFileResolverInterface $submenuFileResolver
     *
     * @return self
     */
    public function setSubmenuFileResolver(SubmenuFileResolverInterface $submenuFileResolver): SubmenuPage
    {
        $this->submenuFileResolver = $submenuFileResolver;

        return $this;
    }

    /**
     * Get the value of parentFileResolver
     *
     * @return null|ParentFileResolverInterface
     */
    public function getParentFileResolver(): ?ParentFileResolverInterface
    {
        return $this->parentFileResolver;
    }

    /**
     * Set the value of parentFileResolver
     *
     * @param ParentFileResolverInterface $parentFileResolver
     *
     * @return self
     */
    public function setParentFileResolver(ParentFileResolverInterface $parentFileResolver): SubmenuPage
    {
        $this->parentFileResolver = $parentFileResolver;

        return $this;
    }

    public function defineSubmenuFile(string $submenuFile, string $parentFile): string
    {
        return $this->getSubmenuFileResolver()->resolveSubmenuFile($submenuFile, $parentFile);
    }

    public function defineParentFile(string $parentFile): string
    {
        return $this->getParentFileResolver()->resolveParentFile($parentFile);
    }
}
