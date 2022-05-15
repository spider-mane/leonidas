<?php

namespace Leonidas\Library\Core\View;

use Leonidas\Contracts\Ui\ViewInterface;

class PhpView implements ViewInterface
{
    /**
     * @var string;
     */
    protected string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function render(array $context = []): string
    {
        ob_start();
        include $this->file;

        return ob_get_clean();
    }
}
