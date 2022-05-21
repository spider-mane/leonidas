<?php

namespace Leonidas\Library\Core\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Core\Util\OutputBuffer;

class PhpView implements ViewInterface
{
    protected string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function render(array $data = []): string
    {
        return OutputBuffer::require($this->file, $data);
    }
}
