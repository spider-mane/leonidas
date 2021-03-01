<?php

namespace WebTheory\Leonidas\Admin\Page;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLayoutInterface;
use WebTheory\Saveyour\Contracts\FormSubmissionManagerInterface;

class SelfLoadingAdminPage extends AbstractSelfLoadingAdminPage
{
    /**
     * @var null|FormSubmissionManagerInterface
     */
    protected $formSubmissionManager;

    /**
     *
     */
    public function __construct(
        string $menuSlug,
        AdminPageLayoutInterface $layout,
        ?FormSubmissionManagerInterface $formSubmissionManager,
        ?string $capability = null
    ) {
        $this->menuSlug = $menuSlug;
        $this->layout = $layout;

        $formSubmissionManager && $this->formSubmissionManager = $formSubmissionManager;
        $capability && $this->capability = $capability;
    }

    /**
     * Set the value of layout
     *
     * @param AdminPageLayoutInterface $layout
     *
     * @return self
     */
    public function setLayout(AdminPageLayoutInterface $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the value of formSubmissionManager
     *
     * @return null|FormSubmissionManagerInterface
     */
    public function getFormSubmissionManager(): ?FormSubmissionManagerInterface
    {
        return $this->formSubmissionManager;
    }

    /**
     *
     */
    public function hasFormSubmissionManager(): bool
    {
        return isset($this->formSubmissionManager);
    }

    /**
     *
     */
    public function renderPage(array $args)
    {
        $this->layout->setTitle($this->pageTitle);

        $request = ServerRequest::fromGlobals()
            ->withAttribute('args', $args);

        if ($this->hasFormSubmissionManager() && $request->getMethod() === 'POST') {
            $this->getFormSubmissionManager()->process($request);
        }

        if ($this->layout->shouldBeRendered($request)) {
            echo $this->getLayout()->renderComponent($request);
        } else {
            echo $this->getErrorPage()->renderComponent($request);
        }
    }
}
