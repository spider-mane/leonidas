<?php

namespace Leonidas\Contracts\Admin\Component\Capsule;

use Leonidas\Contracts\Admin\Component\Page\AdminPageLayoutInterface;
use Leonidas\Contracts\Admin\Component\Page\AdminTitleResolverInterface;
use Leonidas\Contracts\Admin\Component\Page\LoadErrorPageInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

interface AdminPageCapsuleInterface
{
    public function title(): string;

    public function slug(): string;

    public function capability(): string;

    public function policy(): ServerRequestPolicyInterface;

    public function layout(): AdminPageLayoutInterface;

    public function error(): LoadErrorPageInterface;

    public function titleResolver(): ?AdminTitleResolverInterface;
}
