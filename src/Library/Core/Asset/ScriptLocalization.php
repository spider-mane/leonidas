<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationInterface;
use Psr\Http\Message\ServerRequestInterface;

class ScriptLocalization implements ScriptLocalizationInterface
{
    protected string $handle;

    protected string $variable;

    protected array $data;

    protected ?ConstrainerCollectionInterface $constraints = null;

    public function __construct(
        string $handle,
        string $variable,
        array $data,
        ?ConstrainerCollectionInterface $constraints
    ) {
        $this->handle = $handle;
        $this->variable = $variable;
        $this->data = $data;

        $constraints && $this->constraints = $constraints;
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

    public function getConstraints(): ?ConstrainerCollectionInterface
    {
        return $this->constraints;
    }

    public function shouldBeLoaded(ServerRequestInterface $request): bool
    {
        return !$this->constraints->constrains($request);
    }
}
