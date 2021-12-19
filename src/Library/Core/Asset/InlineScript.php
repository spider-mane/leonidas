<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptInterface;

class InlineScript extends AbstractInlineAsset implements InlineScriptInterface
{
    protected string $position = 'after';

    public function __construct(
        string $handle,
        string $data,
        ?string $position = null,
        ?ConstrainerCollectionInterface $constraints = null
    ) {
        parent::__construct($handle, $data, $constraints);

        $position && $this->position = $position;
    }

    public function getPosition(): string
    {
        return $this->position;
    }
}
