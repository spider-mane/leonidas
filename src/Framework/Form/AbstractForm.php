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
use Psr\SimpleCache\CacheInterface;
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
use WebTheory\Saveyour\Data\SimpleCacheDataManager;
use WebTheory\Saveyour\Field\Type\Hidden;
use WebTheory\Saveyour\Processor\FailedValidationSimpleCache;
use WebTheory\Saveyour\Processor\SimpleCacheSweeper;

abstract class AbstractForm implements FormInterface
{
    use AccessesSimpleCacheTrait;
    use UtilizesExtensionTrait;
    use FluentlySetsPropertiesTrait;
    use TranslatesTextTrait;

    protected string $handle;

    protected string $action;

    /**
     * Fields being handled for the current request
     *
     * @var array<string>
     */
    protected array $processing;

    protected WpExtensionInterface $extension;

    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
        $this->init('construct');
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
        $this->init('build');
        $this->processing = $this->fields($request);

        $data = [
            'method' => $this->formMethod(),
            'action' => $this->formAction($request),
            'checks' => $this->formChecks($request),
            'fields' => $this->formFields($request),
            'errors' => $this->formErrors($request),
        ];

        $this->resetStateProps();

        return $data;
    }

    public function process(ServerRequestInterface $request): void
    {
        $this->init('process');
        $this->processing = $this->fields($request);

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
            $this->fieldControllers($request),
            $this->processes($request),
            $this->shield($request),
        );
    }

    /**
     * @return array<FormFieldControllerInterface>
     */
    protected function fieldControllers(ServerRequestInterface $request): array
    {
        $data = $this->dataManagers($request);
        $validation = $this->validation($request);
        $formatting = $this->formatting($request);

        $controllers = [];

        foreach ($this->processing as $field) {
            $name = $this->fieldKeyAsName($field);

            $controllers[] = FormFieldControllerBuilder::for($name)
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
        $attributes = $this->attributes($request);
        $data = $this->dataManagers($request);
        $formatting = $this->formatting($request);

        $controllers = [];

        foreach ($this->processing as $field) {
            $name = $this->fieldKeyAsName($field);

            $controller = FormFieldControllerBuilder::for($name)
                ->dataManager($data[$field] ?? null)
                ->formatter($formatting[$field] ?? null)
                ->get();

            $definition = $attributes[$field] ?? [];

            $definition['name'] = $name;
            $definition['value'] = $controller->getPresetValue($request);

            $controllers[$field] = $definition;
        }

        return $controllers;
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
            $field = $this->fieldNameAsKey($field);
            $errors[$field] = [];

            foreach ($violations as $violation) {
                $message = $messages[$field][$violation];
                $errors[$field][$violation] = $this->translate($message);
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

    protected function fieldKeyAsName(string $key): string
    {
        return $this->prefix(str_replace('_', '-', $key), '-');
    }

    protected function fieldKeysAsNames(array $keys): array
    {
        return array_map([$this, 'fieldKeyAsName'], $keys);
    }

    protected function fieldNameAsKey(string $name): string
    {
        $stripped = substr($name, strlen($this->extension->getPrefix()) + 1);

        return str_replace('-', '_', $stripped);
    }

    protected function fieldNamesAsKeys(array $names): array
    {
        return array_map([$this, 'fieldNameAsKey'], $names);
    }

    protected function mappedResults(array $results): array
    {
        $mapped = [];

        foreach ($results as $name => $value) {
            $mapped[$this->fieldNameAsKey($name)] = $value;
        }

        return $mapped;
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
            $this->actionFormCheck(),
            $this->refererFormCheck(),
            $this->csrfTokenFormCheck(),
        ];
    }

    protected function actionFormCheck(): string
    {
        return (new Hidden())
            ->setName('action')
            ->setValue($this->action)
            ->toHtml();
    }

    protected function refererFormCheck(): string
    {
        return wp_referer_field(false);
    }

    protected function csrfTokenFormCheck(): string
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
        return new Nonce($action = $this->getAction(), $action, Nonce::EXP_12);
    }

    /**
     * @return array<FormDataProcessorInterface>
     */
    protected function processes(ServerRequestInterface $request): array
    {
        return [
            $this->failedValidationCache(),
            $this->transientFieldCacheCleaner($request),
        ];
    }

    protected function failedValidationCache(): FormDataProcessorInterface
    {
        return new FailedValidationSimpleCache(
            'cached_violations',
            $this->simpleCache(),
            $this->failedValidationCacheKey()
        );
    }

    protected function transientFieldCacheCleaner(ServerRequestInterface $request): FormDataProcessorInterface
    {
        return new SimpleCacheSweeper(
            'transient_fields',
            $this->simpleCache(),
            array_map([$this, 'transientFieldCacheKey'], $this->processing)
        );
    }

    /**
     * @return array<string,null|FieldDataManagerInterface>
     */
    protected function dataManagers(ServerRequestInterface $request): array
    {
        $managers = [];

        foreach ($this->processing as $key) {
            $managers[$key] = $this->transientDataManager($key);
        }

        return $managers;
    }

    protected function transientDataManager(string $key): FieldDataManagerInterface
    {
        return new SimpleCacheDataManager(
            $this->getSimpleCache(),
            $this->transientFieldCacheKey($key)
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

    protected function simpleCache(): CacheInterface
    {
        return $this->getService('transients_channel');
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

    protected function resetStateProps(): void
    {
        unset($this->processing);
    }

    protected function initiationContexts(): array
    {
        return [
            'construct' => $this->constructInitiationContext(),
            'build' => $this->buildInitiationContext(),
            'process' => $this->processInitiationContext(),
        ];
    }

    protected function cacheKey(string $sub): string
    {
        return "form:{$this->handle}:{$sub}";
    }

    protected function failedValidationCacheKey(): string
    {
        return $this->cacheKey('errors');
    }

    protected function transientFieldCacheKey(string $key): string
    {
        return $this->cacheKey("submitted.{$key}");
    }

    protected function constructInitiationContext(): array
    {
        return ['handle', 'action'];
    }

    protected function buildInitiationContext(): array
    {
        return ['simpleCache', 'localizer'];
    }

    protected function processInitiationContext(): array
    {
        return ['simpleCache'];
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

    protected function action(): string
    {
        return $this->prefix($this->getHandle(), '_');
    }

    abstract protected function handle(): string;

    /**
     * @return array<string>
     */
    abstract protected function fields(ServerRequestInterface $request): array;

    /**
     * @return array<string,array<string,mixed>|FormFieldInterface>
     */
    abstract protected function attributes(ServerRequestInterface $request): array;

    /**
     * @return array<string,array<string,string>>
     */
    abstract protected function errorMessages(ServerRequestInterface $request): array;
}
