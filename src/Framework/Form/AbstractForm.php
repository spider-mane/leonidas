<?php

namespace Leonidas\Framework\Form;

use Leonidas\Contracts\Auth\CsrfFieldPrinterInterface;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Contracts\Http\Form\FormInterface;
use Leonidas\Framework\Module\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Traits\UtilizesExtensionTrait;
use Leonidas\Library\Core\Auth\CsrfFieldPrinter;
use Leonidas\Library\Core\Auth\Nonce;
use Leonidas\Library\Core\Http\Policy\CsrfCheck;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Auth\FormShield;
use WebTheory\Saveyour\Contracts\Auth\FormShieldInterface;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Controller\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Contracts\Data\FieldDataManagerInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;
use WebTheory\Saveyour\Contracts\Report\ProcessedFormReportInterface;
use WebTheory\Saveyour\Contracts\Report\ValidationReportInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;
use WebTheory\Saveyour\Controller\Builder\FormFieldControllerBuilder;
use WebTheory\Saveyour\Controller\FormSubmissionManager;
use WebTheory\Saveyour\Field\Type\Hidden;

abstract class AbstractForm implements FormInterface
{
    use UtilizesExtensionTrait;
    use FluentlySetsPropertiesTrait;

    protected string $handle;

    protected string $action;

    protected WpExtensionInterface $extension;

    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
        $this->setProperties('handle', 'action');
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function build(ServerRequestInterface $request): array
    {
        return [
            'method' => $this->formMethod(),
            'action' => $this->formAction($request),
            'checks' => $this->formChecks($request),
            'fields' => $this->formFields($request),
        ];
    }

    public function process(ServerRequestInterface $request): void
    {
        $processed = $this->postProcess(
            $this->form($request)->process($request),
            $request
        );

        $this->redirect($this->redirectTo($request, $processed));
    }

    public function validate(ServerRequestInterface $request, string $field, $value): ValidationReportInterface
    {
        $validators = $this->validation($request);

        return $validators[$field]->inspect($value);
    }

    protected function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }

    protected function form(ServerRequestInterface $request): FormSubmissionManagerInterface
    {
        return new FormSubmissionManager(
            $this->controllers($request),
            $this->processors($request),
            $this->shield($request),
        );
    }

    protected function postProcess(ProcessedFormReportInterface $report, ServerRequestInterface $request): ProcessedFormReportInterface
    {
        return $report;
    }

    /**
     * @return array<FormFieldControllerInterface>
     */
    protected function controllers(ServerRequestInterface $request): array
    {
        $controllers = [];
        $data = $this->data($request);
        $validation = $this->validation($request);
        $formatting = $this->formatting($request);

        foreach ($this->fields($request) as $field => $args) {
            $controllers[] = FormFieldControllerBuilder::for($field)
                ->dataManager($data[$field] ?? null)
                ->formatter($formatting[$field] ?? null)
                ->validator($validation[$field] ?? null)
                ->get();
        }

        return $controllers;
    }

    /**
     * @return array<string|array|FormFieldInterface>
     */
    protected function formFields(ServerRequestInterface $request): array
    {
        $fields = $this->fields($request);
        $data = $this->data($request);
        $formatting = $this->formatting($request);

        foreach ($fields as $field => &$definition) {
            $builder = FormFieldControllerBuilder::for($field)
                ->dataManager($data[$field] ?? null)
                ->formatter($formatting[$field] ?? null);

            $definition['value'] = $builder->get()->getPresetValue($request);
        }

        return $fields;
    }

    protected function formMethod(): string
    {
        return 'post';
    }

    protected function formAction(ServerRequestInterface $request): string
    {
        return esc_url(admin_url('admin-post.php'));
    }

    protected function formChecks(ServerRequestInterface $request): string
    {
        return implode("\n", $this->checks($request));
    }

    /**
     * @return array<string>
     */
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
        return $this->csrfPrinter()->print($this->token());
    }

    protected function shield(ServerRequestInterface $request): FormShieldInterface
    {
        return new FormShield($this->policies($request));
    }

    /**
     * @return array<string,ServerRequestPolicyInterface>
     */
    protected function policies(ServerRequestInterface $request): array
    {
        return [
            'csrf' => $this->csrfAuthenticator(),
        ];
    }

    protected function csrfAuthenticator(): ServerRequestPolicyInterface
    {
        return new CsrfCheck($this->token());
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
        return wp_get_referer() ?: home_url();
    }

    protected function redirectTo(ServerRequestInterface $request, ProcessedFormReportInterface $report): ?string
    {
        return null;
    }

    protected function csrfPrinter(): CsrfFieldPrinterInterface
    {
        return new CsrfFieldPrinter();
    }

    /**
     * @return array<FormDataProcessorInterface>
     */
    protected function processors(ServerRequestInterface $request): array
    {
        return [];
    }

    /**
     * @return array<string,null|FieldDataManagerInterface>
     */
    protected function data(ServerRequestInterface $request): array
    {
        return [];
    }

    /**
     * @return array<string,null|ValidatorInterface>
     */
    protected function validation(ServerRequestInterface $request): array
    {
        return [];
    }

    /**
     * @return array<string,null|DataFormatterInterface>
     */
    protected function formatting(ServerRequestInterface $request): array
    {
        return [];
    }

    abstract protected function handle(): string;

    abstract protected function action(): string;

    /**
     * @return array<string,array<string,mixed>|FormFieldInterface>
     */
    abstract protected function fields(ServerRequestInterface $request): array;
}
