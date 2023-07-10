<?php

namespace Leonidas\Library\System\Request\Policy;

use Leonidas\Library\System\Request\Abstracts\ExpectsUserEntityTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class UserEntityPolicy implements ServerRequestPolicyInterface
{
    use ExpectsUserEntityTrait;

    /**
     * @var array<int>
     */
    protected array $users;

    public function __construct(int ...$users)
    {
        $this->users = $users;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return in_array($this->getUserId($request), $this->users);
    }
}
