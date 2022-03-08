<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Http\Policy\ServerRequestPolicyInterface;

interface InlineStyleBuilderInterface
{
    public function handle(string $handle);

    public function code(string $code);

    public function policy(?ServerRequestPolicyInterface $policy);

    public function done(): InlineStyleInterface;
}
