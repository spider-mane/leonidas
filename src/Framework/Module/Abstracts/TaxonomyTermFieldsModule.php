<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Component\TermField\TermFieldInterface;
use Leonidas\Contracts\Admin\Printer\TermFieldPrinterInterface;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\Traits\HasExtraConstructionTrait;
use Leonidas\Hooks\TargetsCreatedXTaxonomyHook;
use Leonidas\Hooks\TargetsEditedXTaxonomyHook;
use Leonidas\Hooks\TargetsXTaxonomyAddFormFieldsHook;
use Leonidas\Hooks\TargetsXTaxonomyAddFormHook;
use Leonidas\Hooks\TargetsXTaxonomyEditFormFieldsHook;
use Leonidas\Hooks\TargetsXTaxonomyTermEditFormTopHook;
use Leonidas\Library\Admin\Printer\BasicTermFieldPrinter;
use Leonidas\Library\Admin\Printer\DeferrableTermFieldPrinter;
use Leonidas\Library\Core\Http\Policy\CsrfCheck;
use Leonidas\Library\Core\Http\Policy\NoAutosave;
use Leonidas\Library\Core\Http\Policy\Permission\EditTerm;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Auth\FormShield;
use WebTheory\Saveyour\Contracts\Auth\FormShieldInterface;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Controller\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Contracts\Report\ProcessedFormReportInterface;
use WebTheory\Saveyour\Controller\FormSubmissionManager;
use WP_Term;

abstract class TaxonomyTermFieldsModule extends Module implements ModuleInterface
{
    use HasExtraConstructionTrait;
    use TargetsCreatedXTaxonomyHook;
    use TargetsEditedXTaxonomyHook;
    use TargetsXTaxonomyAddFormFieldsHook;
    use TargetsXTaxonomyAddFormHook;
    use TargetsXTaxonomyEditFormFieldsHook;
    use TargetsXTaxonomyTermEditFormTopHook;

    protected string $taxonomy;

    protected function afterConstruction(): void
    {
        $this->taxonomy = $this->taxonomy();
    }

    protected function getTaxonomy(): string
    {
        return $this->taxonomy;
    }

    public function hook(): void
    {
        $this->targetCreatedXTaxonomyHook();
        $this->targetEditedXTaxonomyHook();
        $this->targetXTaxonomyAddFormFieldsHook();
        $this->targetXTaxonomyAddFormHook();
        $this->targetXTaxonomyEditFormFieldsHook();
        $this->targetXTaxonomyTermEditFormTopHook();
    }

    protected function doXTaxonomyAddFormAction(string $taxonomy): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('taxonomy', $taxonomy)
            ->withAttribute('context', $this->getScreenContext());

        echo $this->renderCsrfToken($request);
    }

    protected function doXTaxonomyTermEditFormTopAction(WP_Term $term, string $taxonomy): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('term', $term)
            ->withAttribute('taxonomy', $taxonomy)
            ->withAttribute('context', $this->getScreenContext());

        echo $this->renderCsrfToken($request);
    }

    protected function doXTaxonomyAddFormFieldsAction(string $taxonomy): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('taxonomy', $taxonomy)
            ->withAttribute('context', $this->getScreenContext());

        echo $this->renderFields($request);
    }

    protected function doXTaxonomyEditFormFieldsHookAction(WP_Term $term, string $taxonomy): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('term', $term)
            ->withAttribute('taxonomy', $taxonomy)
            ->withAttribute('context', $this->getScreenContext());

        echo $this->renderFields($request);
    }

    protected function doCreatedXTaxonomyAction(int $termId, int $ttId): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('term_id', $termId)
            ->withAttribute('tt_id', $ttId);

        $this->processSubmittedFormData($request);
    }

    protected function doEditedXTaxonomyAction(int $termId, int $ttId): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('term_id', $termId)
            ->withAttribute('tt_id', $ttId);

        $this->processSubmittedFormData($request);
    }

    protected function getScreenContext()
    {
        return get_current_screen()->base;
    }

    protected function renderCsrfToken(ServerRequestInterface $request): ?string
    {
        return ($nonce = $this->token()) ? $nonce->renderField() : null;
    }

    protected function renderFields(ServerRequestInterface $request): string
    {
        $printer = new DeferrableTermFieldPrinter($this->printer());

        return $printer->print($this->fields(), $request);
    }

    protected function processSubmittedFormData(ServerRequestInterface $request): void
    {
        $this->postFormProcessing($this->form()->process($request), $request);
    }

    protected function form(): FormSubmissionManagerInterface
    {
        return new FormSubmissionManager(
            $this->formFields(),
            [],
            $this->formShield()
        );
    }

    protected function formShield(): FormShieldInterface
    {
        $policies = ['user_cannot_edit' => new EditTerm()];

        if ($this->allowAutosave()) {
            $policies['no_autosave'] = new NoAutosave();
        }

        if ($token = $this->token()) {
            $policies['invalid_request'] = new CsrfCheck($token);
        }

        return new FormShield($policies);
    }

    protected function token(): ?CsrfManagerInterface
    {
        $taxonomy = $this->getTaxonomy();
        $context = $this->getScreenContext();

        return $this->csrfRepository()->get("{$context}_{$taxonomy}");
    }

    protected function csrfRepository(): CsrfManagerRepositoryInterface
    {
        return $this->getService(CsrfManagerRepositoryInterface::class);
    }

    protected function printer(): ?TermFieldPrinterInterface
    {
        return new BasicTermFieldPrinter();
    }

    protected function allowAutosave(): bool
    {
        return false;
    }

    protected function postFormProcessing(ProcessedFormReportInterface $form, ServerRequestInterface $request): void
    {
        //
    }

    abstract protected function taxonomy(): string;

    /**
     * @return TermFieldInterface[]
     */
    abstract protected function fields(): array;

    /**
     * @return FormFieldControllerInterface[]
     */
    abstract protected function formFields(): array;
}
