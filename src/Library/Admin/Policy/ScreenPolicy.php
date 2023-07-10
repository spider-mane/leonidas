<?php

namespace Leonidas\Library\Admin\Policy;

use Leonidas\Library\Admin\Abstracts\ExpectsScreenTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class ScreenPolicy implements ServerRequestPolicyInterface
{
    use ExpectsScreenTrait;

    /**
     * @var array<string>
     */
    protected array $screens;

    public function __construct(string ...$screens)
    {
        $this->screens = $screens;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return in_array($this->getScreenId($request), $this->screens);
    }
}
