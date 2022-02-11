<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Admin\Components\TermFieldInterface;
use Leonidas\Contracts\Admin\Components\TermFieldPrinterInterface;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\HasExtraConstructionTrait;
use Leonidas\Library\Admin\Term\Printers\BasicTermFieldPrinter;
use Leonidas\Library\Admin\Term\Printers\DeferrableTermFieldPrinter;
use Leonidas\Library\Core\Auth\Nonce;
use Leonidas\Library\Core\Http\Form\Authenticators\CsrfCheck;
use Leonidas\Library\Core\Http\Form\Authenticators\NoAutosave;
use Leonidas\Library\Core\Http\Form\Authenticators\Permissions\EditTerm;
use Leonidas\Traits\Hooks\TargetsCreatedXTaxonomyHook;
use Leonidas\Traits\Hooks\TargetsEditedXTaxonomyHook;
use Leonidas\Traits\Hooks\TargetsXTaxonomyAddFormFieldsHook;
use Leonidas\Traits\Hooks\TargetsXTaxonomyAddFormHook;
use Leonidas\Traits\Hooks\TargetsXTaxonomyEditFormFieldsHook;
use Leonidas\Traits\Hooks\TargetsXTaxonomyTermEditFormTopHook;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormProcessingCacheInterface;
use WebTheory\Saveyour\Contracts\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Controllers\FormSubmissionManager;
use WP_Term;

abstract class AbstractTaxonomyTermFieldsModule extends AbstractModule implements ModuleInterface
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

    protected function doXTaxonomyAddFormAction(): void
    {
        $request = $this->getServerRequest()
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
        $manager = new FormSubmissionManager();

        foreach ($this->formFields() as $field) {
            $manager->addField($field);
        }

        $manager->addValidator('user_cannot_edit', new EditTerm());

        if (!$this->allowAutosave()) {
            $manager->addValidator('no_autosave', new NoAutosave());
        }

        if ($token = $this->token()) {
            $manager->addValidator('invalid_request', new CsrfCheck($token));
        }

        return $manager;
    }

    protected function token(): ?CsrfManagerInterface
    {
        $prefix = $this->getExtension()->getPrefix();
        $user = get_current_user();
        $taxonomy = $this->getTaxonomy();
        $context = $this->getScreenContext();

        $name = "{$prefix}_{$user}_{$context}_{$taxonomy}_nonce";
        $action = "{$prefix}_{$user}_{$context}_{$taxonomy}";

        return new Nonce($name, $action, Nonce::EXP_12);
    }

    protected function printer(): ?TermFieldPrinterInterface
    {
        return new BasicTermFieldPrinter();
    }

    protected function allowAutosave(): bool
    {
        return false;
    }

    protected function postFormProcessing(FormProcessingCacheInterface $form, ServerRequestInterface $request): void
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
