<?php

namespace Leonidas\Library\Admin\Processing;

use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Library\Admin\Component\Notice\StandardAdminNotice;
use Leonidas\Library\Admin\Policy\ScreenPolicy;
use Leonidas\Library\Core\Http\Policy\CompositePolicy;
use Leonidas\Library\System\Request\Policy\UserEntityPolicy;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Contracts\Processor\FormDataProcessorInterface;
use WebTheory\Saveyour\Contracts\Report\FormProcessReportInterface;
use WebTheory\Saveyour\Processor\Abstracts\AbstractFormDataProcessor;

class AdminNoticeInjector extends AbstractFormDataProcessor implements FormDataProcessorInterface
{
    protected ServerRequestPolicyInterface $noticePolicy;

    public function __construct(
        string $name,
        protected AdminNoticeRepositoryInterface $repository,
        protected array $data
    ) {
        parent::__construct($name, null);
    }

    public function process(ServerRequestInterface $request, array $results): ?FormProcessReportInterface
    {
        foreach ($results as $field => $result) {
            foreach ($result->ruleViolations() as $violation) {
                if ($data = $this->getData($violation)) {
                    $this->repository->add(new StandardAdminNotice(
                        $data['id'],
                        $data['message'],
                        $field,
                        $data['type'] ?? 'error',
                        $data['dismissible'] ?? true,
                        $this->getNoticePolicy()
                    ));
                }
            }
        }

        return null;
    }

    protected function getData(string $key): array|false
    {
        return $this->data[$key] ?? false;
    }

    protected function getNoticePolicy(): ServerRequestPolicyInterface
    {
        return $this->noticePolicy ??= new CompositePolicy(
            new UserEntityPolicy(wp_get_current_user()->ID),
            new ScreenPolicy(get_current_screen()->id)
        );
    }
}
