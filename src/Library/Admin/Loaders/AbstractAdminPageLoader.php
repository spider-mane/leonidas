<?php

namespace Leonidas\Library\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Contracts\Admin\Components\AdminPageInterface;
use Leonidas\Contracts\Admin\Components\AdminPageLoadErrorInterface;

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
    public function hook(): AbstractAdminPageLoader
    {
        $this->targetAdminMenuHook();

        return $this;
    }

    /**
     *
     */
    protected function targetAdminMenuHook(): AbstractAdminPageLoader
    {
        add_action('admin_menu', [$this, 'register']);

        return $this;
    }

    /**
     *
     */
    protected function targetAdminTitleHook(): AbstractAdminPageLoader
    {
        add_filter('admin_title', [$this, 'resolveAdminTitle'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     *
     */
    public function register(): AbstractAdminPageLoader
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
    public function renderPage(array $args): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('args', $args);

        if ($this->adminPage->shouldBeRendered($request)) {
            echo $this->adminPage->renderComponent($request);
        } else {
            echo $this->errorPage->renderComponent($request);
        }
    }

    protected function getServerRequest(): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }

    abstract protected function addPage(): AbstractAdminPageLoader;

    abstract protected function removePage(): AbstractAdminPageLoader;
}
