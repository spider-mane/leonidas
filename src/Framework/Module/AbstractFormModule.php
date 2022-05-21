<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Http\Form\FormHandlerInterface;
use Leonidas\Contracts\Http\Form\FormHandlerRepositoryInterface;
use Leonidas\Framework\Module\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Hooks\TargetsAdminPostNoprivXActionHook;
use Leonidas\Hooks\TargetsAdminPostXActionHook;
use Leonidas\Hooks\TargetsInitHook;
use Leonidas\Library\Core\Auth\Nonce;
use Leonidas\Library\Core\Http\Policy\CsrfCheck;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Auth\FormShield;
use WebTheory\Saveyour\Contracts\Auth\FormShieldInterface;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Controller\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Contracts\Processor\FormDataProcessorInterface;
use WebTheory\Saveyour\Contracts\Report\ProcessedFormReportInterface;
use WebTheory\Saveyour\Controller\FormSubmissionManager;
use WebTheory\Saveyour\Field\Type\Hidden;

abstract class AbstractFormModule extends AbstractModule implements ModuleInterface, FormHandlerInterface
{
    use FluentlySetsPropertiesTrait;
    use TargetsAdminPostXActionHook;
    use TargetsAdminPostNoprivXActionHook;
    use TargetsInitHook;

    protected string $handle;

    protected string $action;

    protected function getAction(): string
    {
        return $this->action;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function hook(): void
    {
        $this->setProperties('handle', 'action');

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
        $this->repository()->add($this);
    }

    protected function process(ServerRequestInterface $request)
    {
        $processed = $this->postProcessing(
            $this->form($request)->process($request),
            $request
        );

        $this->redirect($this->redirectTo($request, $processed));
    }

    protected function form(ServerRequestInterface $request): FormSubmissionManagerInterface
    {
        return new FormSubmissionManager(
            $this->fields($request),
            $this->processors($request),
            $this->formShield($request),
        );
    }

    protected function postProcessing(ProcessedFormReportInterface $report, ServerRequestInterface $request): ProcessedFormReportInterface
    {
        return $report;
    }

    public function build(ServerRequestInterface $request): array
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
     * @return array<string|array|FormFieldInterface>
     */
    protected function formFields(ServerRequestInterface $request): array
    {
        return array_map(
            fn (FormFieldControllerInterface $field) => $this->getFormFieldData(
                $field->compose($request)
            ),
            $this->fields($request)
        );
    }

    /**
     * @return string|array|FormFieldInterface
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

    protected function formShield(ServerRequestInterface $request): FormShieldInterface
    {
        return new FormShield([
            'csrf' => $this->csrfTokenAuthenticator(),
        ]);
    }

    protected function csrfTokenAuthenticator(): ServerRequestPolicyInterface
    {
        return new CsrfCheck($this->token());
    }

    /**
     * @return array<FormDataProcessorInterface>
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

    protected function redirectTo(ServerRequestInterface $request, ProcessedFormReportInterface $report): ?string
    {
        return null;
    }

    abstract protected function handle(): string;

    abstract protected function action(): string;

    abstract protected function repository(): FormHandlerRepositoryInterface;

    /**
     * @return array<FormFieldControllerInterface>
     */
    abstract protected function fields(ServerRequestInterface $request): array;
}
