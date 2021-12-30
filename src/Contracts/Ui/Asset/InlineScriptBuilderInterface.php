<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;

interface InlineScriptBuilderInterface
{
    public function handle(string $handle);

    public function code(string $code);

    public function position(string $position);

    public function constraints(?ConstrainerCollectionInterface $constraints);

    public function done(): InlineScriptInterface;
}
