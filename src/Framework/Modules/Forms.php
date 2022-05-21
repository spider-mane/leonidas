<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Http\Form\FormInterface;
use Leonidas\Contracts\Http\Form\FormRepositoryInterface;
use Leonidas\Framework\Modules\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Modules\Traits\HasModuleConfigurationTrait;
use Leonidas\Hooks\TargetsAdminPostNoprivXActionHook;
use Leonidas\Hooks\TargetsAdminPostXActionHook;
use Leonidas\Hooks\TargetsInitHook;
use Leonidas\Hooks\TargetsWpAjaxNoprivXActionHook;
use Leonidas\Hooks\TargetsWpAjaxXActionHook;
use WebTheory\Saveyour\Http\Request;

class Forms extends AbstractModule implements ModuleInterface
{
    use FluentlySetsPropertiesTrait;
    use HasModuleConfigurationTrait;
    use TargetsInitHook;
    use TargetsAdminPostXActionHook;
    use TargetsAdminPostNoprivXActionHook;
    use TargetsWpAjaxXActionHook;
    use TargetsWpAjaxNoprivXActionHook;

    public const MODULE = 'leonidas:forms';

    protected FormRepositoryInterface $repository;

    private string $currentAction;

    public function hook(): void
    {
        $this->targetInitHook();
    }

    final protected function getAction(): string
    {
        return $this->currentAction;
    }

    protected function doInitAction(): void
    {
        $this->setProperty('repository');
        $this->registerForms();
    }

    protected function doAdminPostXActionAction(): void
    {
        $this->processForm();
    }

    protected function doAdminPostNoprivXActionAction(): void
    {
        $this->processForm();
    }

    protected function doWpAjaxXActionAction(): void
    {
        $this->validateInput();
    }

    protected function doWpAjaxNoprivXActionAction(): void
    {
        $this->validateInput();
    }

    protected function registerForms(): void
    {
        foreach ($this->forms() as $form) {
            $this->repository->add($form = $this->initForm($form));

            $this->currentAction = $form->getAction();

            if ($form->onPriv()) {
                $this->targetAdminPostXActionHook();
                $this->targetWpAjaxXActionHook();
            }

            if ($form->onNopriv()) {
                $this->targetAdminPostNoprivXActionHook();
                $this->targetWpAjaxNoprivXActionHook();
            }

            unset($this->currentAction);
        }
    }

    protected function processForm()
    {
        $request = $this->getServerRequest();
        $action = Request::var($request, 'action');

        $this->getForm($action)->process($request);

        $this->redirect();

        exit;
    }

    protected function validateInput(): void
    {
        $request = $this->getServerRequest();

        $action = Request::var($request, 'action');
        $field = Request::var($request, 'field');
        $value = Request::var($request, 'value');

        $this->getForm($action)->validate($request, $field, $value);

        exit;
    }

    protected function initForm(string $form): FormInterface
    {
        return new $form($this->extension);
    }

    protected function getForm(string $action): FormInterface
    {
        return $this->repository->mapped($action);
    }

    protected function redirect(): void
    {
        wp_safe_redirect(wp_get_referer() ?: home_url());
    }

    protected function forms(): array
    {
        return $this->configured('index', 'app.forms', []);
    }

    protected function repository(): FormRepositoryInterface
    {
        return $this->getService(FormRepositoryInterface::class);
    }
}
