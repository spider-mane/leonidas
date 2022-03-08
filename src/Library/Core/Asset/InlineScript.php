<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\Policy\ServerRequestPolicyInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptInterface;

class InlineScript extends AbstractInlineAsset implements InlineScriptInterface
{
    protected string $position = 'after';

    public function __construct(
        string $handle,
        string $data,
        ?string $position = null,
        ?ServerRequestPolicyInterface $policy = null
    ) {
        parent::__construct($handle, $data, $policy);

        $position && $this->position = $position;
    }

    public function getPosition(): string
    {
        return $this->position;
    }
}
