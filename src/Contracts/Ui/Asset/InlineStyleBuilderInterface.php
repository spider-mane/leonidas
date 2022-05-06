<?php

namespace Leonidas\Contracts\Ui\Asset;

use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

interface InlineStyleBuilderInterface
{
    public function handle(string $handle);

    public function code(string $code);

    public function policy(?ServerRequestPolicyInterface $policy);

    public function done(): InlineStyleInterface;
}
