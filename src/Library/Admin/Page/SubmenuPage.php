<?php

namespace Leonidas\Library\Admin\Page;

use GuzzleHttp\Psr7\ServerRequest;
use Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Components\AdminPageLoadErrorInterface;
use Leonidas\Contracts\Admin\Components\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Components\ParentFileResolverInterface;
use Leonidas\Contracts\Admin\Components\SubmenuFileResolverInterface;
use Leonidas\Contracts\Admin\Components\SubmenuPageInterface;
use Leonidas\Traits\CanBeRestrictedTrait;

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
