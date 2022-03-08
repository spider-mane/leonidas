<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Http\ServerRequestPolicyInterface;

interface InlineScriptBuilderInterface
{
    public function handle(string $handle);

    public function code(string $code);

    public function position(string $position);

    public function policy(?ServerRequestPolicyInterface $policy);

    public function done(): InlineScriptInterface;
}
