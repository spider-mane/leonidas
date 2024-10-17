<?php

namespace Leonidas\Framework\Capsule\Abstracts;

use Leonidas\Contracts\Admin\Component\Capsule\MetaboxCapsuleInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Library\Admin\Processing\AdminNoticeInjector;
use Leonidas\Library\Core\Http\Policy\CsrfCheck;
use Leonidas\Library\Core\Http\Policy\NoAutosave;
use Leonidas\Library\Core\Http\Policy\NoPolicy;
use Leonidas\Library\Core\Http\Policy\Permission\EditPost;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Auth\FormShield;
use WebTheory\Saveyour\Contracts\Auth\FormShieldInterface;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Controller\FormSubmissionManagerInterface;
use WebTheory\Saveyour\Contracts\Processor\FormDataProcessorInterface;
use WebTheory\Saveyour\Controller\FormSubmissionManager;

abstract class MetaboxCapsule extends Capsule implements MetaboxCapsuleInterface
{
    public function context(): string
    {
        return 'advanced';
    }

    public function priority(): string
    {
        return 'default';
    }

    public function args(): array
    {
        return [];
    }

    public function policy(): ?ServerRequestPolicyInterface
    {
        return new NoPolicy();
    }

    public function processor(ServerRequestInterface $request): FormSubmissionManagerInterface
    {
        return new FormSubmissionManager(
            $this->formFields($request),
            $this->formProcessors($request),
            $this->formShield($request)
        );
    }

    public function noticeRepository(): AdminNoticeRepositoryInterface
    {
        return $this->getService(AdminNoticeRepositoryInterface::class);
    }

    /**
     * @return array<FormFieldControllerInterface>
     */
    protected function formFields(ServerRequestInterface $request): array
    {
        return [];
    }

    /**
     * @return array<FormDataProcessorInterface>
     */
    protected function formProcessors(ServerRequestInterface $request): array
    {
        return [
            new AdminNoticeInjector(
                'admin-notices',
                $this->adminNoticeRepository(),
                $this->alerts()
            ),
        ];
    }

    protected function formShield(ServerRequestInterface $request): FormShieldInterface
    {
        return new FormShield([
            'user_cannot_edit' => new EditPost(),
            'no_autosave' => new NoAutosave(),
            'invalid_request' => new CsrfCheck($this->token()),
        ]);
    }

    protected function token(): ?CsrfManagerInterface
    {
        return $this->csrfRepository()->get("update_{$this->screen()}");
    }

    protected function csrfRepository(): CsrfManagerRepositoryInterface
    {
        return $this->getService(CsrfManagerRepositoryInterface::class);
    }

    protected function adminNoticeRepository(): AdminNoticeRepositoryInterface
    {
        return $this->getService(AdminNoticeRepositoryInterface::class);
    }

    protected function alerts(): array
    {
        return [];
    }

    protected function isGetRequest(ServerRequestInterface $request): bool
    {
        return 'GET' === $request->getMethod();
    }

    protected function isPostRequest(ServerRequestInterface $request): bool
    {
        return 'POST' === $request->getMethod();
    }
}
