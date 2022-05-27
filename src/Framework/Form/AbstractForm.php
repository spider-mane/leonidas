<?php

namespace Leonidas\Framework\Form;

use Leonidas\Contracts\Auth\CsrfFieldPrinterInterface;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Contracts\Http\Form\FormInterface;
use Leonidas\Framework\Abstracts\AccessesSimpleCacheTrait;
use Leonidas\Framework\Abstracts\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Abstracts\TranslatesTextTrait;
use Leonidas\Framework\Abstracts\UtilizesExtensionTrait;
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
use WebTheory\Saveyour\Contracts\Processor\FormDataProcessorInterface;
use WebTheory\Saveyour\Contracts\Report\ProcessedFormReportInterface;
use WebTheory\Saveyour\Contracts\Report\ValidationReportInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;
use WebTheory\Saveyour\Controller\Builder\FormFieldControllerBuilder;
use WebTheory\Saveyour\Controller\FormSubmissionManager;
use WebTheory\Saveyour\Field\Type\Hidden;
use WebTheory\Saveyour\Processor\FailedValidationSimpleCache;

abstract class AbstractForm implements FormInterface
{
    use AccessesSimpleCacheTrait;
    use UtilizesExtensionTrait;
    use FluentlySetsPropertiesTrait;
    use TranslatesTextTrait;

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
        $this->setProperties('localizer');

        return [
            'method' => $this->formMethod(),
            'action' => $this->formAction($request),
            'checks' => $this->formChecks($request),
            'fields' => $this->formFields($request),
            'errors' => $this->formErrors($request),
        ];
    }

    public function process(ServerRequestInterface $request): void
    {
        $processed = $this->postProcess(
            $this->processor($request)->process($request),
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

    protected function processor(ServerRequestInterface $request): FormSubmissionManagerInterface
    {
        return new FormSubmissionManager(
            $this->controllers($request),
            $this->processes($request),
            $this->shield($request),
        );
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

        foreach ($this->fieldData($request) as $field => $args) {
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
        $fields = $this->fieldData($request);
        $data = $this->data($request);
        $formatting = $this->formatting($request);

        foreach ($fields as $field => &$definition) {
            $name = $this->fieldKeyAsName($field);
            $controller = FormFieldControllerBuilder::for($name)
                ->dataManager($data[$field] ?? null)
                ->formatter($formatting[$field] ?? null)
                ->get();

            $definition['value'] = $controller->getPresetValue($request);
        }

        return $fields;
    }

    /**
     * @return array<string,array<int,string>>
     */
    protected function formErrors(ServerRequestInterface $request): array
    {
        $errors = [];
        $messages = $this->errorMessages($request);
        $violations = $this->getCachedViolations($request);

        foreach ($violations as $field => $violations) {
            $errors[$field] = [];

            foreach ($violations as $violation) {
                $field = $this->fieldNameAsKey($field);
                $message = $messages[$field][$violation];

                $errors[$field][] = $this->translate($message);
            }
        }

        return $errors;
    }

    protected function getCachedViolations(ServerRequestInterface $request): array
    {
        $cache = $this->simpleCache();
        $key = $this->failedValidationCacheKey();

        $violations = $cache->get($key, []);

        $cache->delete($key);

        return $violations;
    }

    protected function failedValidationCacheKey(): string
    {
        return "form:{$this->handle}:errors";
    }

    protected function fieldKeyAsName(string $key): string
    {
        return $this->prefix(str_replace('_', '-', $key), '-');
    }

    protected function fieldNameAsKey(string $name): string
    {
        return str_replace(
            [$this->prefix('', '-'), '-'],
            ['', '_'],
            $name
        );
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

    /**
     * @return array<FormDataProcessorInterface>
     */
    protected function processes(ServerRequestInterface $request): array
    {
        return [
            $this->failedValidationPersister(),
        ];
    }

    protected function failedValidationPersister(): FormDataProcessorInterface
    {
        return new FailedValidationSimpleCache(
            'cached_violations',
            $this->simpleCache(),
            $this->failedValidationCacheKey()
        );
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

    protected function csrfPrinter(): CsrfFieldPrinterInterface
    {
        return new CsrfFieldPrinter();
    }

    protected function redirectTo(ServerRequestInterface $request, ProcessedFormReportInterface $report): ?string
    {
        return null;
    }

    protected function postProcess(ProcessedFormReportInterface $report, ServerRequestInterface $request): ProcessedFormReportInterface
    {
        return $report;
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
    abstract protected function fieldData(ServerRequestInterface $request): array;

    /**
     * @return array<string,array<string,string>>
     */
    abstract protected function errorMessages(ServerRequestInterface $request): array;
}
