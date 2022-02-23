<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Http\Form\FormHandlerInterface;
use Leonidas\Contracts\Http\Form\FormRepositoryInterface;
use Leonidas\Framework\Modules\Traits\HasExtraConstructionTrait;
use Leonidas\Library\Core\Auth\Nonce;
use Leonidas\Library\Core\Http\Form\Authenticators\CsrfCheck;
use Leonidas\Traits\Hooks\TargetsAdminPostNoprivXActionHook;
use Leonidas\Traits\Hooks\TargetsAdminPostXActionHook;
use Leonidas\Traits\Hooks\TargetsInitHook;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormDataProcessorInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Contracts\FormProcessingCacheInterface;
use WebTheory\Saveyour\Contracts\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;
use WebTheory\Saveyour\Controllers\FormProcessingCache;
use WebTheory\Saveyour\Controllers\FormSubmissionManager;
use WebTheory\Saveyour\Fields\Hidden;

abstract class AbstractFormModule extends AbstractModule implements ModuleInterface, FormHandlerInterface
{
    use HasExtraConstructionTrait;
    use TargetsAdminPostXActionHook;
    use TargetsAdminPostNoprivXActionHook;
    use TargetsInitHook;

    protected string $action;

    protected function afterConstruction(): void
    {
        $this->action = $this->action();
    }

    protected function getAction(): string
    {
        return $this->action;
    }

    public function hook(): void
    {
        $this->targetInitHook();
        $this->targetAdminPostXActionHook();
        $this->targetAdminPostNoprivXActionHook();
    }

    protected function doInitAction(): void
    {
        $this->registerForm();
    }

    protected function doAdminPostXActionAction(): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('user', get_current_user());

        $this->process($request);
    }

    protected function doAdminPostNoprivXActionAction(): void
    {
        $request = $this->getServerRequest();

        $this->process($request);
    }

    protected function registerForm(): void
    {
        $this->repository()->add($this->alias(), $this);
    }

    protected function process(ServerRequestInterface $request)
    {
        $processed = $this->postProcessing(
            $this->form($request)->process($request),
            $request
        );

        $this->redirect($this->redirectTo($request, $processed));
    }

    protected function postProcessing(
        FormProcessingCacheInterface $cache,
        ServerRequestInterface $request
    ): FormProcessingCacheInterface {
        return $cache;
    }

    protected function form(ServerRequestInterface $request): FormSubmissionManagerInterface
    {
        return (new FormSubmissionManager())
            ->setValidators($this->authenticators($request))
            ->setFields(...array_values($this->fields($request)))
            ->setProcessors(...array_values($this->processors($request)));
    }

    public function getBuild(ServerRequestInterface $request): array
    {
        return [
            'method' => $this->formMethod(),
            'action' => $this->formAction(),
            'checks' => $this->formChecks($request),
            'fields' => $this->formFields($request),
        ];
    }

    protected function formMethod(): string
    {
        return 'post';
    }

    protected function formAction(): string
    {
        return esc_url(admin_url('admin-post.php'));
    }

    /**
     * @return string[]|array[]|FormFieldInterface[]
     */
    protected function formFields(ServerRequestInterface $request): array
    {
        return array_map(
            fn (FormFieldControllerInterface $field) => $this->getFormFieldData(
                $field->render($request)
            ),
            $this->fields($request)
        );
    }

    /**
     * @return string|string[]|FormFieldInterface
     */
    protected function getFormFieldData(FormFieldInterface $field)
    {
        return [
            'id' => $field->getId(),
            'name' => $field->getName(),
            'value' => $field->getValue(),
            'disabled' => $field->isDisabled(),
            'readonly' => $field->isReadOnly(),
            'required' => $field->isRequired(),
        ];
    }

    protected function formChecks(ServerRequestInterface $request): string
    {
        return implode("\n", $this->checks($request));
    }

    protected function checks(ServerRequestInterface $request): array
    {
        return [
            $this->actionField(),
            $this->refererField(),
            $this->csrfTokenField(),
        ];
    }

    protected function actionField(): string
    {
        return (new Hidden())
            ->setName('action')
            ->setValue($this->action)
            ->toHtml();
    }

    protected function refererField(): string
    {
        return wp_referer_field(false);
    }

    protected function csrfTokenField(): string
    {
        return $this->token()->renderField();
    }

    /**
     * @return FormValidatorInterface[]
     */
    protected function authenticators(ServerRequestInterface $request): array
    {
        return [
            $this->csrfTokenAuthenticator(),
        ];
    }

    protected function csrfTokenAuthenticator(): FormValidatorInterface
    {
        return new CsrfCheck($this->token());
    }

    /**
     * @return FormDataProcessorInterface[]
     */
    protected function processors(ServerRequestInterface $request): array
    {
        return [];
    }

    protected function token(): CsrfManagerInterface
    {
        $action = $this->getAction();

        return new Nonce($action, $action, Nonce::EXP_12);
    }

    protected function redirect(?string $location = null): void
    {
        wp_safe_redirect($location ?? $this->redirectDefault());

        exit;
    }

    protected function redirectDefault(): string
    {
        return wp_get_referer();
    }

    protected function redirectTo(ServerRequestInterface $request, FormProcessingCache $cache): ?string
    {
        return null;
    }

    abstract protected function action(): string;

    abstract protected function alias(): string;

    abstract protected function repository(): FormRepositoryInterface;

    /**
     * @return FormFieldControllerInterface[]
     */
    abstract protected function fields(ServerRequestInterface $request): array;
}