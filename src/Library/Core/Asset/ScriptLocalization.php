<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptLocalizationInterface;

class ScriptLocalization implements ScriptLocalizationInterface
{
    protected string $handle;

    protected string $variable;

    protected array $data;

    public function __construct(string $handle, string $variable, array $data)
    {
        $this->handle = $handle;
        $this->variable = $variable;
        $this->data = $data;
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
}
