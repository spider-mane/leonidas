<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ServerRequestPolicyInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationInterface;
use Leonidas\Library\Core\Http\Policies\NoPolicy;
use Psr\Http\Message\ServerRequestInterface;

class ScriptLocalization implements ScriptLocalizationInterface
{
    protected string $handle;

    protected string $variable;

    protected array $data;

    protected ?ServerRequestPolicyInterface $policy = null;

    public function __construct(
        string $handle,
        string $variable,
        array $data,
        ?ServerRequestPolicyInterface $policy
    ) {
        $this->handle = $handle;
        $this->variable = $variable;
        $this->data = $data;

        $this->policy = $policy ?? new NoPolicy();
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function getVariable(): string
    {
        return $this->variable;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getPolicy(): ?ServerRequestPolicyInterface
    {
        return $this->policy;
    }

    public function shouldBeLoaded(ServerRequestInterface $request): bool
    {
        return $this->policy->approvesRequest($request);
    }
}
