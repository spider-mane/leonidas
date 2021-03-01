<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Admin\Contracts\AdminPageInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLoadErrorInterface;

abstract class AbstractAdminPageLoader
{
    /**
     * @var AdminPageInterface
     */
    protected $adminPage;

    /**
     * @var AdminPageLoadErrorInterface
     */
    protected $errorPage;

    /**
     *
     */
    public function hook()
    {
        $this->targetAdminMenuHook();

        return $this;
    }

    /**
     *
     */
    protected function targetAdminMenuHook()
    {
        add_action('admin_menu', [$this, 'register']);

        return $this;
    }

    /**
     *
     */
    protected function targetAdminTitleHook()
    {
        add_filter('admin_title', [$this, 'resolveAdminTitle'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     *
     */
    public function register()
    {
        $this->addPage()->configurePage();

        return $this;
    }

    /**
     *
     */
    protected function configurePage(): AbstractAdminPageLoader
    {
        if (!$this->adminPage->isShownInMenu()) {
            $this->removePage();
        }

        $this->targetAdminTitleHook();

        return $this;
    }

    /**
     *
     */
    public function resolveAdminTitle(string $adminTitle, string $title): string
    {
        return $this->adminPage->defineAdminTitle($adminTitle, $title);
    }

    /**
     *
     */
    public function renderPage(array $args)
    {
        $request = ServerRequest::fromGlobals()
            ->withAttribute('args', $args);

        if ($this->adminPage->shouldBeRendered($request)) {
            echo $this->adminPage->renderComponent($request);
        } else {
            echo $this->errorPage->renderComponent($request);
        }
    }

    abstract protected function addPage(): AbstractAdminPageLoader;

    abstract protected function removePage(): AbstractAdminPageLoader;
}
